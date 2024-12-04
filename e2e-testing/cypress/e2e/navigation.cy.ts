describe('Navigation from the main menu', () => {
  before(() => {
    cy.login();
  });

  it('Navigates to old manuscript creation', () => {
    cy.visit('/home');
    cy.get('button')
      .contains('Manuscripts (Old Data Model)')
      .click();
    cy.get('a')
      .contains('New Manuscript')
      .filter(':visible')
      .click();
  });
});
