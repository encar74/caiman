import { apiLoginScopes, ApiScope } from "./lib/apiLogin";
import yargs from "yargs";
import { loginWithBrowserExample } from "./examples/loginWithBrowserExample";
import { listCompaniesExample } from "./examples/listCompaniesExample";
import { listInvoicesExample } from "./examples/listInvoicesExample";
import { createInvoiceExample } from "./examples/createInvoiceExample";

yargs
  .usage("Usage $0 <command> [optiona]")
  .command("loginWithBrowser", "Runs an authorization against the FacturaDirecta authorizaion server and prints the obtained credentials", async () => {
    const argv = yargs
      .example("$0 loginWithBrowser --scopes invoices:read", "Runs an authorization against the FacturaDirecta authorizaion server and prints the obtained credentials")
      .option("promptAlways", {
        describe: "Prompt credentials always even if some user is already logged in the browser",
        type: "boolean",
        default: false
      })
      .option("scopes", {
        descripe: "Space separated list of API scopes",
        type: "string",
        array: true,
        demandOption: true,
        choices: ["all"].concat(...apiLoginScopes())
      })
      .option("saveCredentialsTo", {
        descripe: "Optional path to save retrieved credentials",
        type: "string",
      })
      .help("h")
      .parseSync();
    try {
      await loginWithBrowserExample({ scopes: argv.scopes as ApiScope[], promptAlways: argv.promptAlways, saveCredentialsTo: argv.saveCredentialsTo });
    } catch (e) {
      console.log("Error running loginWithBrowser command", e);
      process.exit(1);
    }
  })
  .command("listCompanies", "List companies using stored credentials or requesting new ones", async () => {
    const argv = yargs
      .example("$0 listCompanies --credentials ~/.facturadirectaApiCredentials.json", "Prints a list of the companies that the user can access. Credentials may be passed from a json file or obtained by the command itself")
      .option("credentials", {
        describe: "Path to a JSON file with api credentials obtained with a call to apiLogin",
        type: "string"
      })
      .help("h")
      .parseSync();
    try {
      await listCompaniesExample(argv.credentials);
    } catch (e) {
      console.log("Error running listCompanies command", e);
      process.exit(1);
    }
  })
  .command("listInvoices", "List latest invoices of a company", async () => {
    const argv = yargs
      .example("$0 listCompanies --apiKey xxxxxx.yyyyyyyyyyy --companyId com_000...", "List latest invoices of a company")
      .option("credentials", {
        describe: "Path to a JSON file with api credentials obtained with a call to apiLogin",
        type: "string"
      })
      .option("apiKey", {
        describe: "API Key to use as credentials",
        type: "string"
      })
      .option("companyId", {
        describe: "ID of the company. If not indicated and the provided credentials are from OAuth authorization system the example will query for the companies with access and will use the first one",
        type: "string"
      })
      .conflicts("credentials", "apiKey")
      .check((argv) => {
        if (!argv.credentials && !argv.apiKey) {
          throw new Error("Please, use one of credentials or apiKey");
        }
        return true;
      })
      .help("h")
      .parseSync();
    try {
      if (argv.credentials) {
        await listInvoicesExample({ credentialsPath: argv.credentials, companyId: argv.companyId });  
      } else if (argv.apiKey) {
        await listInvoicesExample({ apiKey: argv.apiKey, companyId: argv.companyId });
      }
    } catch (e) {
      console.log("Error running listCompanies command", e);
      process.exit(1);
    }
  })
  .command("createInvoice", "Create a sample invoice", async () => {
    const argv = yargs
      .example("$0 createInvoice --credentials ~/.facturadirectaApiCredentials.json --companyId com_000... --getPdf false", "Create a sample invoice")
      .option("credentials", {
        describe: "Path to a JSON file with api credentials obtained with a call to apiLogin",
        type: "string"
      })
      .option("apiKey", {
        describe: "API Key to use as credentials",
        type: "string"
      })
      .option("companyId", {
        describe: "ID of the company",
        type: "string",
        demandOption: true
      })
      .option("createPdf", {
        describe: "Create a pdf for the new invoice and return the URL",
        type: "boolean",
        default: false
      })
      .conflicts("credentials", "apiKey")
      .check((argv) => {
        if (!argv.credentials && !argv.apiKey) {
          throw new Error("Please, use one of credentials or apiKey");
        }
        return true;
      })
      .help("h")
      .parseSync();
    try {
      if (argv.credentials) {
        await createInvoiceExample({ credentialsPath: argv.credentials, companyId: argv.companyId, createPdf: argv.createPdf });
      } else {
        await createInvoiceExample({ apiKey: argv.apiKey, companyId: argv.companyId, createPdf: argv.createPdf });
      }
    } catch (e) {
      console.log("Error running listCompanies command", e);
      process.exit(1);
    }
  })
  .demand(1)
  .strict()
  .help("h")
  .alias("h", "help")
  .argv;