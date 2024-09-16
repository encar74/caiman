import { refreshCredentials } from "./apiLogin";
import {
  AnyCredential, ApiCallResult, apiHeaders, API_BASE_URL,
  ProfileUser
} from "./apiCommon";
import got from "got";

export async function getProfile(params: { credentials: AnyCredential }): Promise<ApiCallResult<ProfileUser>> {
  const { credentials } = params;
  const updatedCredentials = await refreshCredentials({ credentials });
  const res = await got.
    get(`${API_BASE_URL}/profile`,
      {
        headers: apiHeaders(updatedCredentials),
        responseType: "json"
      });
  return {
    credentials: updatedCredentials,
    data: (res.body as any).profile as ProfileUser
  };
}