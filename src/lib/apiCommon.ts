import { JwtPayload } from "jsonwebtoken";
import { Headers } from "got";

const APP_BASE_URL = process.env.FD_APP_BASE_URL || "https://app.facturadirecta.com";
export const API_BASE_URL: string = process.env.FD_API_BASE_URL || `${APP_BASE_URL}/api`;
export const AUTH_SERVER: string = process.env.FD_API_AUTH_SERVER || "https://auth.facturadirecta.com/auth/realms/facturadirecta/protocol/openid-connect";

// Begin API definition  types
import { components, operations } from "../@types/facturadirecta";

// Common
export type Tags = components["schemas"]["Tags"];
export type PaginationQuery = { limit?: number, offset?: number };

// Profile
export type ProfileUser = components["schemas"]["ProfileUser"];

// Invoice
export type Invoice = components["schemas"]["Invoice"];
export type GetInvoicesQuery = Exclude<operations["getInvoices"]["parameters"], undefined>["query"] & PaginationQuery;
export type GetInvoicesResponse = operations["getInvoices"]["responses"][200]["content"]["application/json"];

type _CreateInvoiceRequestBody = operations["createInvoice"]["requestBody"]["content"]["application/json"];
export type InvoiceWrite = _CreateInvoiceRequestBody["content"];
export type InvoiceWritePayments = Exclude<_CreateInvoiceRequestBody["payments"], undefined>;
export type CreateInvoiceRequestBody = {
  content: InvoiceWrite,
  tags?: Tags,
  payments?: InvoiceWritePayments
};

export type CreateInvoiceResponse = operations["createInvoice"]["responses"][200]["content"]["application/json"];

export type CreateInvoicePDFRequestBody = operations["createInvoicePDF"]["requestBody"]["content"]["application/json"];
export type CreateInvoicePDFResponse = operations["createInvoicePDF"]["responses"][200]["content"]["application/json"];

// End API definition types

export interface ApiCallResult<T> {
  credentials: AnyCredential;
  data: T;
}

export type ApiKey = string;
export type AnyCredential = ApiCredentials | DecodedApiCredentials | ApiKey;

export interface ApiCredentials {
  access_token: string;
  expires_in: number;
  refresh_token: string;
  refresh_expires_in: number;
  scope: string;
  username: string;
};

export interface DecodedApiCredentials extends ApiCredentials {
  decoded: {
    accessToken: AccessToken,
    refreshToken: RefreshToken
  }
}

export interface AccessToken extends JwtPayload {
  scope: string;
  preferred_username: string;
}

export interface RefreshToken extends JwtPayload {
  scope: string;
}

export function apiHeaders(credentials: AnyCredential): Headers {
  const headers: Headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
  };
  if (typeof credentials === "string") { // ApiKey
    headers["facturadirecta-api-key"] = credentials;
  } else {
    headers["Authorization"] = `Bearer ${credentials.access_token}`;
  }
  return headers;
}

export function getSearchParams(query?: any): URLSearchParams | undefined {
  if (query) {
    const result = new URLSearchParams();
    Object.keys(query).forEach((key) => {
      const value = query[key];
      if (Array.isArray(value)) {
        value.forEach((item) => {
          result.append(key, item);
        });
      } else {
        result.append(key, value);
      }
    });
    return result;
  }
  return undefined;
}

export function webDocumentUrl(params: { companyId: string, documentId: string }) {
  return `${APP_BASE_URL}#/${params.companyId}/document/${params.documentId}`;
}