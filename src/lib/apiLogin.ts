import express = require('express');
import open from "open";
import { AddressInfo } from 'net'
import { randomBytes } from "crypto";
import got from "got";
import { decode as decodeToken, JwtPayload } from "jsonwebtoken";
import { promisify } from "util";
import { readFile } from "fs";
import Ajv, { ErrorObject, ValidateFunction } from "ajv"
import { omit } from 'lodash';
import {
  AUTH_SERVER, AnyCredential, DecodedApiCredentials, ApiCredentials,
  AccessToken, RefreshToken
} from './apiCommon';

export type ApiScope = "offline_access" |
  "contacts:read" | "contacts:write" |
  "products:read" | "products:write" |
  "invoices:read" | "invoices:write" |
  "estimates:read" | "estimates:write" |
  "deliveryNotes:read" | "deliveryNotes:write" |
  "bills:read" |
  "payrolls:read" | "payrolls:write" |
  "recurring:read" | "recurring:write" |
  "banks:read" | "banks:readIban" |
  "paymentMethods:read" | "paymentMethods:readIban" | "paymentMethods:write" |
  "accounting:read" |
  "settings:read";

export function apiLoginScopes(): ApiScope[] {
  return [
    "offline_access",
    "contacts:read", "contacts:write",
    "products:read", "products:write",
    "invoices:read", "invoices:write",
    "estimates:read", "estimates:write",
    "deliveryNotes:read", "deliveryNotes:write",
    "bills:read",
    "payrolls:read", "payrolls:write", 
    "recurring:read", "recurring:write",
    "banks:read", "banks:readIban",
    "paymentMethods:read", "paymentMethods:readIban", "paymentMethods:write", 
    "accounting:read",
    "settings:read"
  ];
};

const AUTTHORIZATION_URL = `${AUTH_SERVER}/auth`;
const TOKEN_URL = `${AUTH_SERVER}/token`;
const CLIENT_ID = "facturadirecta-api"
const CLIENT_SECRET = "";

export async function refreshCredentials(params: { credentials: AnyCredential, minValiditySeconds?: number }): Promise<AnyCredential> {
  let { credentials, minValiditySeconds } = params;
  if (typeof credentials === "string") {
    return credentials; // If is a string is an ApiKey, no need to refresh, just return input credentials
  }

  let { decodedCredentials, returnDecodedCredentials } = (() => {
    const hasDecoded = (credentials as DecodedApiCredentials).decoded != null;
    return {
      decodedCredentials: hasDecoded ? credentials : decodeCredentials(credentials),
      returnDecodedCredentials: hasDecoded
    } as { decodedCredentials: DecodedApiCredentials, returnDecodedCredentials: boolean };
  })();
  decodedCredentials = await getFreshCredentials({ credentials: decodedCredentials, minValiditySeconds });
  return returnDecodedCredentials ? decodedCredentials : cleanDecodedApiCredentilas(decodedCredentials);
}

const apiCredentialsSchema = {
  "$id": "apiCredentials",
  type: "object",
  additionalProperties: false,
  required: ["access_token", "expires_in", "refresh_token", "refresh_expires_in", "scope", "username"],
  properties: {
    access_token: { type: "string" },
    expires_in: { type: "number" },
    refresh_token: { type: "string" },
    refresh_expires_in: { type: "number" },
    scope: { type: "string" },
    username: { type: "string" },
  }
};

let apiCredentialsValidationFunction: ValidateFunction | undefined = undefined;
function validateApiCredentials(candidate: any): { valid: boolean, errors?: null | ErrorObject[] } {
  if (!apiCredentialsValidationFunction) {
    const ajv = new Ajv({ verbose: true, messages: true, removeAdditional: false });
    apiCredentialsValidationFunction = ajv.compile(apiCredentialsSchema);
  }
  const valid = apiCredentialsValidationFunction(candidate);
  const result: { valid: boolean, errors?: null | ErrorObject[] } = { valid };
  if (!valid) {
    result.errors = apiCredentialsValidationFunction.errors;
  }
  return result;
}

export async function apiLogin(params: { scopes: ApiScope[], promptAlways?: boolean }): Promise<ApiCredentials> {
  const { scopes } = params;
  const promptAlways = params.promptAlways != null ? params.promptAlways : true; // Default to true
  let authorizationUrl = AUTTHORIZATION_URL;
  if (promptAlways) {
    authorizationUrl += `?prompt=login`
  }
  const { code, redirectUri } = await browserOAuthCode({ authorizationUrl, scopes });

  const accessTokenRequestParams = {
    grant_type: "authorization_code",
    code,
    client_id: CLIENT_ID,
    client_secret: CLIENT_SECRET,
    redirect_uri: redirectUri
  };

  const res = await got.post(TOKEN_URL, {
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    form: accessTokenRequestParams,
    responseType: "json"
  });

  const body = res.body as ApiCredentials;
  return apiCredentialsFromServerResponse(res.body as ApiCredentials);
}

function apiCredentialsFromServerResponse(body: ApiCredentials): ApiCredentials {
  const decoded = decodeAccessToken(body.access_token) as { preferred_username: string };
  return {
    access_token: body.access_token,
    expires_in: body.expires_in,
    refresh_token: body.refresh_token,
    refresh_expires_in: body.refresh_expires_in,
    scope: body.scope,
    username: decoded.preferred_username
  };
}

export async function loadApiCredentials(path: string): Promise<ApiCredentials> {
  const str = await promisify(readFile)(path, "utf-8");
  try {
    const jsonCredentials = JSON.parse(str);
    // return jsonCredentials as unknown as ApiCredentials;
    validateApiCredentials(jsonCredentials);
    return jsonCredentials as unknown as ApiCredentials;
  } catch (e) {
    // Throw default error
  }
  throw new Error("Invalid file for credentials");
}

export function decodeCredentials(credentials: ApiCredentials): DecodedApiCredentials {
  const accessToken = decodeToken(credentials.access_token) as AccessToken;
  const refreshToken = decodeToken(credentials.refresh_token) as RefreshToken;
  return { decoded: { accessToken, refreshToken }, ...credentials }
}

export function cleanDecodedApiCredentilas(credentials: DecodedApiCredentials): ApiCredentials {
  return omit(credentials, ["decoded"]) as ApiCredentials;
}

export async function getFreshCredentials(params: { credentials: DecodedApiCredentials, minValiditySeconds?: number }): Promise<DecodedApiCredentials> {
  // By default te refresh the token if it expres in less than 5 minutes
  const { credentials } = params;
  const minValiditySeconds = params.minValiditySeconds == null ? 300 : params.minValiditySeconds;
  const now = Math.floor(new Date().getTime() / 1000);
  const tokenExpires = credentials.decoded.accessToken.exp!;
  const mustRefreshToken = minValiditySeconds <= 0 || (now + minValiditySeconds) > tokenExpires;
  if (!mustRefreshToken) {
    return credentials; // No need to refresh
  }
  const refreshTokenRequestParams = {
    grant_type: "refresh_token",
    refresh_token: credentials.refresh_token,
    client_id: CLIENT_ID
  };
  const res = await got.post(TOKEN_URL, {
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    form: refreshTokenRequestParams,
    responseType: "json"
  });
  return decodeCredentials(apiCredentialsFromServerResponse(res.body as ApiCredentials));
}

function decodeAccessToken(accessToken: string): JwtPayload | null {
  return decodeToken(accessToken, { json: true });
}

type AuthCodeResult = { type: "code", code: string, redirectUri: string } | { type: "error", error: Error };
async function browserOAuthCode(params: { authorizationUrl: string, scopes: ApiScope[] }): Promise<{ code: string, redirectUri: string }> {
  const state = randomBytes(20).toString('hex');
  const url = `${params.authorizationUrl}` +
    (params.authorizationUrl.indexOf("?") === -1 ? "?" : "&") + `client_id=${encodeURIComponent(CLIENT_ID)}` +
    `&client_secret=${CLIENT_SECRET}` +
    `&response_type=code` +
    `&scope=${encodeURIComponent(params.scopes.join(" "))}` +
    `&state=${encodeURIComponent(state)}`;

  const authResult: AuthCodeResult = await new Promise<AuthCodeResult>((resolve, reject) => {
    const redirectUriPath = "/oauth2Callback";
    let redirectUri: string | undefined = undefined;
    try {
      const app = express();
      let port = undefined;
      app.get(redirectUriPath, async (req, res) => {
        try {
          if (req.query.state !== state) {
            throw new Error("Invalid state");
          }
          if (!req.query.code) {
            throw new Error("Missing code parameter");
          }
          res.send(sucessHtml());
          resolve({ type: "code", code: req.query.code as string, redirectUri: redirectUri! });
        } catch (e) {
          res.status(400);
          res.send(errorHtml(e as Error));
          reject(e);
        }
        server.close();
      });

      const server = app.listen(0, () => {
        port = (server.address() as AddressInfo).port;
        redirectUri = `http://localhost:${port}${redirectUriPath}`;
        console.log("Listening on: " + redirectUri);
        const finalAuthUrl = url + `&redirect_uri=${encodeURIComponent(redirectUri)}`
        open(finalAuthUrl);
      });

    } catch (e) {
      return { type: "error", error: e };
    }
  });

  if (authResult.type === "error") {
    throw authResult.error;
  }
  const { code, redirectUri } = authResult;
  return { code, redirectUri };
}

function sucessHtml(): string {
  return `<html>
<body>
  <head>
  <script>
  function closeWindow() {
    window.close();
  }
  </script>
  </head>
  <h1>Authorizacion completed</h1>
  <br/><br/>
  You can close the window and see the credentials in the console.
  <script>
  closeWindow(); // Works only if user already logged
  </script>
</body>
</html>
`;
}

function errorHtml(e: Error): string {
  return `<html>
  <body>
  <h1>Authorization error</h1>
  ${(e as Error).message}
  </body>
</html>`;
}