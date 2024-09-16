import { ApiCredentials } from "../lib/apiCommon";
import { apiLogin, loadApiCredentials } from "../lib/apiLogin";
import { getProfile } from "../lib/apiProfile";

export async function listCompaniesExample(credentialsPath?: string): Promise<void> {
  let credentials: ApiCredentials | undefined = undefined;
  if (credentialsPath) {
    credentials = await loadApiCredentials(credentialsPath);
  }

  if (!credentials) {
    // Get new credentials, profile scope is included by default
    credentials = await apiLogin({ scopes: [] });
  }

  const { data: profile, credentials: updatedCredentials } = await getProfile({ credentials });
  if (credentials.access_token !== (updatedCredentials as ApiCredentials).access_token) {
    console.log("INFO: Credentials were refreshed. New credentialas are:\n" + JSON.stringify(updatedCredentials, null, 4));
  }

  console.log("User: " + profile.username);
  console.log("Companies:");
  profile.companies.forEach((company) => {
    console.log(`\t${company.id}\t${company.taxCode}\t${company.brand || company.name}`);
  });
}