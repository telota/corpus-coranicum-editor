import { Component } from './Component';
import { fetchMarkup } from './api';
import { Routes } from './Routes';

export class Variants extends Component {
  private suraSelect!: HTMLElement[];
  private verseSelect!: HTMLElement[];

  constructor(id: string | HTMLElement) {
    super(id, Variants.name);
    this.suraSelect = $("input[name='sure']").get();
    this.verseSelect = $("input[name='vers']").get();
    $(this.verseSelect).on('change', () => this.changeVariantsForm());
    $(this.suraSelect).on('change', () => this.changeVariantsForm());
    console.log("Have the sura menu", this.suraSelect);
    console.log("Have the verse menu", this.verseSelect);
  }

  private changeVariantsForm() {
    console.log('Getting variants!!');
    const sura = $(this.suraSelect).val();
    const verse = $(this.verseSelect).val();
    if (sura && verse) {
      fetchMarkup(Routes.variantsForm(+sura, +verse), (markup: any) => {
        console.log(markup);
        $('#varianten')
          .children()
          .remove();
        $('#varianten').append(markup);
      });
    }
  };

}
