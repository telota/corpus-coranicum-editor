## Introduction

This folder is for making and running end-2-end tests via Cypress.

## System requirements

- npm
- node version 14 or higher.
- Chrome browser
- The [system requirements for Cypress](https://docs.cypress.io/guides/getting-started/installing-cypress#System-requirements)

## Exectuing tests

Most, if not all tests, required logging into ccdb_edit.  To do this, you have to give cypress your login credentials.  There are two ways to do this:

1. `cp cypress.env.example.json cypress.env.json` and add your login credentials to `cypress.env.json`. This file is `.gitignored`.
2.  If you don't like storing your password or username in a file, you can give it directly on the command line.  Instead of running `npm run local-interactive`, you run `npm run local-interactive -- --env USERNAME=user,PASSWORD=yourpassword`, i.e. append any npm run command with ` -- --env USERNAME=user,PASSWORD=yourpassword`.

## Writing tests

Run `npm local-interactive` or `npm dev-interactive`, depending on what environemnt you want to use. This will open a Chrome browser, where you can click on the test you want to run.  Cypress also watches for any changes to the test and reruns it.

Notice that you must set the baseUrl.  You can choose what baseUrl, i.e. local, stage, or prod. See the package.json for examples.

## Running all tests

`npm run [local|dev]`