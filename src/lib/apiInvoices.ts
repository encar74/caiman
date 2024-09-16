import { refreshCredentials } from "./apiLogin";
import {
  AnyCredential, ApiCallResult, apiHeaders, API_BASE_URL, getSearchParams,
  GetInvoicesQuery, GetInvoicesResponse,
  CreateInvoiceRequestBody, CreateInvoiceResponse,
  CreateInvoicePDFRequestBody, CreateInvoicePDFResponse,
} from "./apiCommon";
import got from "got";

export async function getInvoices(params: { credentials: AnyCredential, companyId: string, query?: GetInvoicesQuery }): Promise<ApiCallResult<GetInvoicesResponse>> {
  const { credentials, companyId, query } = params;
  const updatedCredentials = await refreshCredentials({ credentials });
  const res = await got.get(`${API_BASE_URL}/${companyId}/invoices`,
    {
      headers: apiHeaders(updatedCredentials),
      responseType: "json",
      searchParams: getSearchParams(query)
    });
  return {
    credentials: updatedCredentials,
    data: res.body as GetInvoicesResponse
  };
}

export async function createInvoice(params: { credentials: AnyCredential, companyId: string, body: CreateInvoiceRequestBody }): Promise<ApiCallResult<CreateInvoiceResponse>> {
  const { credentials, companyId, body } = params;
  const updatedCredentials = await refreshCredentials({ credentials });
  const res = await got.post(`${API_BASE_URL}/${companyId}/invoices`,
    {
      headers: apiHeaders(updatedCredentials),
      json: body,
      responseType: "json"
    });
  return {
    credentials: updatedCredentials,
    data: res.body as CreateInvoiceResponse
  }
}

export async function createInvoicePDF(params: { credentials: AnyCredential, companyId: string, invoiceId: string, body: CreateInvoicePDFRequestBody }): Promise<ApiCallResult<CreateInvoicePDFResponse>> {
  const { credentials, companyId, invoiceId, body } = params;
  const updatedCredentials = await refreshCredentials({ credentials });
  const res = await got.put(`${API_BASE_URL}/${companyId}/invoices/${invoiceId}/pdf`,
    {
      headers: apiHeaders(updatedCredentials),
      json: body,
      responseType: "json"
    });
  return {
    credentials: updatedCredentials,
    data: res.body as CreateInvoicePDFResponse
  }
}