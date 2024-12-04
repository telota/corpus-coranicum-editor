import path = require('path');
import { Utilities } from './Utilities';

export class ManuscriptPage {
  readonly basePath = 'manuscript-pages';

  create(manuscriptId: number) {
    const createPage = cy.visit(
      path.join(this.basePath, 'create', manuscriptId.toString()),
    );

    createPage
      .get("input[name='folio']")
      .type(Utilities.randomInt(1, 100).toString());
  }
}
