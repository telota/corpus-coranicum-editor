import { Manuscript } from '../types/Manuscript';
describe('Tests various manuscript functionality', () => {
  before(() => {
    cy.login();
  });

  it('Create a new manuscript', () => {
    const manuscriptPage = new Manuscript();
    manuscriptPage.create().then(text => {
      const id = text.replace(/^\D+/g, '');
      console.log(text);
      console.log('here is the id:', id);
    });
  });

  // Working on this. Not even sure it's feasible.
  it.skip('Compare Manuscript New and Old', () => {
    const manuscript = new Manuscript();
    const old = new Manuscript('old');
    const el = manuscript
      .visit(2)
      .get('body')
      .then(body => {
        body.find('ul > li > span');
      });

    const text = el
      .contains(/^Place ID$/)
      .parent()
      .invoke('text');

    // const expectedOldText = text.replace('Place ID', 'AufbewahrungsortId');

    const oldText = old
      .visit(2)
      .get('ul > li > span')
      .contains(/^AufbewahrungsortId$/)
      .parent()
      .invoke('text');

    // expect(expectedOldText).to.equal(oldText);
    //   expect(followSiblings).to.deep.equal(oldSibs);

    // });
  });

});
