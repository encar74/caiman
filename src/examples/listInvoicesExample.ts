import { AnyCredential, ApiCallResult, ApiCredentials, ApiKey, GetInvoicesQuery, GetInvoicesResponse } from "../lib/apiCommon";
import { getInvoices } from "../lib/apiInvoices";
import { loadApiCredentials } from "../lib/apiLogin";
import { getProfile } from "../lib/apiProfile";

export async function listInvoicesExample(params: { credentialsPath?: string, apiKey?: string, companyId?: string }): Promise<void> {
  let { credentialsPath, apiKey, companyId } = params;
  if (!credentialsPath && !apiKey) {
    throw new Error("Please use one of credentialsPath or apiKey");
  }
  if (apiKey && !companyId) {
    throw new Error("Please indicate companyId if you use an api-key");
  }

  const credentials = credentialsPath ? await loadApiCredentials(credentialsPath) : apiKey as ApiKey;
  let updatedCredentials: undefined | AnyCredential = undefined;
  if (!companyId) {
    // We know credentials are OAuth if we are here
    let profileData;
    ({ data: profileData, credentials: updatedCredentials } = await getProfile({ credentials }));
    const profileResponse = await getProfile({ credentials });
    if (profileResponse.data.companies.length > 0) {
      companyId = profileResponse.data.companies[0].id;
      const company = profileResponse.data.companies[0];
      console.log(`Going to list latest invoices for company ${company.brand || company.name} (${company.id})`);
    } else {
      throw new Error(`The provided credentials for user ${(credentials as ApiCredentials).username} do not have access to any company`);
    }
  }

  const query: GetInvoicesQuery = {
    sortBy: ["-date", "formattedSeries", "-number", "-creationDate"],
    limit: 5
  };
  let invoicesData = undefined;
  ({ data: invoicesData, credentials: updatedCredentials } = await getInvoices({ credentials, companyId, query }));

  if (!apiKey) {
    // Check for refreshed credentials only for OAuth
    if ((credentials as ApiCredentials).access_token !== (updatedCredentials as ApiCredentials).access_token) {
      console.log("INFO: Credentials were refreshed. New credentialas are:\n" + JSON.stringify(updatedCredentials, null, 4));
    }
  }

  console.log("Total invoices in query: " + invoicesData.pagination.total);
  console.log("Total invoices in current result page: " + invoicesData.items.length);
  invoicesData.items.forEach((invoiceContainer, i) => {
    console.log("----");
    const invoice = invoiceContainer.content;
    const modificationDate = invoiceContainer.modificationDate;
    const creationDate = invoiceContainer.creationDate;
    console.log(`Invoice title: ${invoice.main.title}`);
    console.log(`Invoice ID: ${invoice.uuid}`);
    console.log(`Creation date: ${creationDate}`);
    console.log(`Latest modification date: ${modificationDate}`);
    console.log(`Total: ${invoice.main.total} ${invoice.main.currency}`);
  });
}