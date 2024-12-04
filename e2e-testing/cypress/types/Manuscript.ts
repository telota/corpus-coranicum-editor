import path = require('path');

export class Manuscript {
  private basePath: string;

  constructor(type?: string) {
    this.basePath = type == 'old' ? 'manuskript' : 'manuscript-new';
  }

  visit(id: number) {
    return cy.visit(path.join(this.basePath, 'show', id.toString()));
  }

  create(): Cypress.Chainable<string> {
    const d = new Date();
    const manuscriptCallnumber =
      'Cypress Test ' + d.toLocaleString().replace(/[^a-zA-Z0-9]/g, '_');
    const createPage = cy.visit(path.join(this.basePath, 'create'));

    createPage.get('input[name="call_number"]').type(manuscriptCallnumber);

    createPage
      .get('select[name="place_id"]')
      .select(Math.ceil(Math.random() * 102), { force: true });

    createPage
      .get('input[name="min_number_lines"]')
      .type(Math.ceil(Math.random() * 50).toString());

    createPage
      .get('button[type="submit"]')
      .contains('Speichern')
      .click();

    cy.get('.alert-success').should('exist');

    return cy
      .get('ul > li > span')
      .contains(/^ID$/)
      .parent()
      .invoke('text');
  }

	update(id: number){

	}
}
