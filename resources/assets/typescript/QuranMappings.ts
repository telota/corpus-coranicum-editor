import { fetchMarkup } from './api';
import { Component } from './Component';
import { Routes } from './Routes';
import $ from 'jquery';
import { CoordinateSelect } from './CoordinateSelect';

export class QuranMappings extends Component {
  constructor(id: string) {
    super(id, QuranMappings.name);
    console.log('Initializing quran passages');
    this.initMappings();
    this.initAddButton();
  }

  private initMapping(passageRoot: HTMLElement) {
    $(passageRoot)
      .find('[name="quran-coordinate-start"], [name="quran-coordinate-end"]' as string)
      .each(function () {
        new CoordinateSelect(this);
      })
      .end()
      .find('[name="delete-quran-mapping"]' as string)
      .on('click', function () {
        console.log('deleted');
        $(this).closest('[name="quran-mapping"]').remove();
      });
  }

  private initMappings() {
    const self = this;
    $('[name="quran-mapping"]').each(function () {
      self.initMapping(this);
    });
  }

  private initAddButton() {
    const self = this;
    $(this.root)
      .find('#new-mapping, #new-verse-mapping' as string)
      .on('click', function () {
        const button = $(this);
        let verseOnly = false;
        if(this.id.includes('new-verse-mapping')){
          verseOnly = true;
        }
        fetchMarkup(Routes.newMapping(verseOnly), function (data: string) {
          const newNode = $(data).insertBefore(button).get(0);
          if (newNode) {
            self.initMapping(newNode);
          }
        });
      });
  }
}
