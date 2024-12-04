Cypress.Commands.add('login', () => {
  cy.session(Cypress.env('USERNAME'), () => {
    cy.visit('auth/login');
    cy.get('#inputEmail').type(Cypress.env('USERNAME'));
    cy.get('#inputPassword').type(Cypress.env('PASSWORD'));
    cy.get('button:submit')
      .contains('Einloggen')
      .click();
    cy.url().should('contain', '/home');
  });
});

// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })
