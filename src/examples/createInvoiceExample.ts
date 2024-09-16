import { ApiCredentials, ApiKey, CreateInvoiceRequestBody, webDocumentUrl } from "../lib/apiCommon";
import { createInvoice, createInvoicePDF } from "../lib/apiInvoices";
import { loadApiCredentials } from "../lib/apiLogin";

export async function createInvoiceExample(params: { credentialsPath?: string, apiKey?: string, companyId: string, createPdf?: boolean }): Promise<void> {
  let { credentialsPath, apiKey, companyId, createPdf } = params;

  let credentials = credentialsPath ? await loadApiCredentials(credentialsPath) : apiKey as ApiKey;
  const body: CreateInvoiceRequestBody = {
    content: {
      type: "invoice",
      main: {
        docNumber: {
          series: "APITEST"
        },
        lines: [
          {
            quantity: 2,
            unitPrice: 75,
            text: "Sample product 1",
            tax: ["S_IVA_21"]
          },
          {
            quantity: 1,
            unitPrice: 120,
            text: "Sample product 2",
            tax: ["S_IVA_21"]
          },
        ],
        notes: "Invoice created from API examples"
      }
    },
    tags: ["Created from API"]
  };

  let { data: newInvoiceData, credentials: updatedCredentials } = await createInvoice({ credentials, companyId, body });
  if (!apiKey) {
    // Check for refreshed credentials only for OAuth
    if ((credentials as ApiCredentials).access_token !== (updatedCredentials as ApiCredentials).access_token) {
      console.log("INFO: Credentials were refreshed. New credentialas are:\n" + JSON.stringify(updatedCredentials, null, 4));
    }
  }

  const invoice = newInvoiceData.content;
  const modificationDate = newInvoiceData.modificationDate;
  const creationDate = newInvoiceData.creationDate;
  console.log(`# Created invoice ${webDocumentUrl({ companyId, documentId: invoice.uuid })}`);
  console.log(`Invoice title: ${invoice.main.title}`);
  console.log(`Invoice ID: ${invoice.uuid}`);
  console.log(`Creation date: ${creationDate}`);
  console.log(`Latest modification date: ${modificationDate}`);
  console.log(`Total: ${invoice.main.total} ${invoice.main.currency}`);
  if (createPdf === true) {
    credentials = updatedCredentials as ApiCredentials;
    let pdfData = undefined;
    ({ data: pdfData, credentials: updatedCredentials } = await createInvoicePDF({ credentials, companyId, invoiceId: invoice.uuid, body: { mode: "inline" } }));
    if (credentials.access_token !== (updatedCredentials as ApiCredentials).access_token) {
      console.log("INFO: Credentials were refreshed. New credentialas are:\n" + JSON.stringify(updatedCredentials, null, 4));
    }
    console.log(`Invoice PDF available at least until ${pdfData.availableUntil} at: ` + pdfData.url);
  }
}