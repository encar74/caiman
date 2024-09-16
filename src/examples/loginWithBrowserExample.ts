import { ApiCredentials } from "../lib/apiCommon";
import { apiLogin, apiLoginScopes, ApiScope } from "../lib/apiLogin";
import { promisify } from "util";
import { writeFile } from "fs";
import { resolve } from "path";
import { uniq, flatten } from "lodash";

export async function loginWithBrowserExample(params: { scopes: ApiScope[], promptAlways: boolean, saveCredentialsTo?: string }): Promise<void> {
  params.scopes = uniq(flatten(params.scopes.map((s: ApiScope | "all") => {
    if (s === "all") {
      return apiLoginScopes();
    }
    return s as ApiScope;
  })));
  const credentials: ApiCredentials = await apiLogin(params);
  console.log("Got credentials:\n" + JSON.stringify(credentials, null, 4));
  if (params.saveCredentialsTo) {
    await promisify(writeFile)(params.saveCredentialsTo, JSON.stringify(credentials, null, 4), "utf-8");
    console.log("Credentials saved to: " + resolve(params.saveCredentialsTo));
  }
}