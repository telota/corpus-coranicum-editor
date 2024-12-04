export class Component {
  root: HTMLElement;

  constructor(identifier: string | HTMLElement, callingComponent: string) {
    let element;
    if (typeof identifier === 'string') {
      element = $(`#${identifier}`).get();
    } else {
      element = $(identifier).get();
    }
    if (element.length == 1) {
      this.root = element[0];
    } else {
      console.error(
        `${element.length} elements found with
         identifier ${identifier} for component ${callingComponent}. 
         Component is worthless, i.e. will have no effect on the DOM.`,
      );
      // This is just to pass the type checker.
      this.root = new HTMLElement();
    }
  }
}
