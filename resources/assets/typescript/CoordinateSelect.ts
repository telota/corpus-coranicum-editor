import { fetchJsonData } from './api';
import { Component } from './Component';
import { QuranWord } from './QuranWord';
import { Routes } from './Routes';
export class CoordinateSelect extends Component {
  private suraSelect!: HTMLElement[];
  private verseSelect!: HTMLElement[];
  private wordSelect!: HTMLElement[];

  constructor(id: string | HTMLElement) {
    super(id, CoordinateSelect.name);

    this.suraSelect = $(this.root).children("select[name^='sura']").get();
    this.verseSelect = $(this.root).children("select[name^='verse']").get();
    this.wordSelect = $(this.root).children("select[name^='word']").get();

    this.initialize();
  }

  private initialize() {
    console.log('Initialize coordinate select');
    this.changeVerseDropdown(false);
    this.changeWordDropdown(false);
    $(this.suraSelect).on('change', ()=> this.changeVerseDropdown())
    $(this.verseSelect).on('change', ()=> this.changeWordDropdown())
    $(this.wordSelect).on('change', ()=> this.setArabWord())
  }

  private makeVerseOptions(max: number): string[] {
    return [...Array(max + 1).keys()].map(
      (n) => `<option value="${n}">${n}</option>`,
    );
  }

  private makeWordOptions(words: QuranWord[]): string[] {
    words.unshift(<QuranWord>{ wort: -1, transkription: 'None Selected', arab: '&nbsp;' });
    const options = words.map(
      (w) =>
        `<option value=${w.wort} data-arab="${w.arab}">${w.wort >= 0 ? w.wort : ""} (${
          w.transkription
        })</option>`
    );
    return options;
  }


  private changeVerseDropdown(clearVerse: boolean = true) {
    const verse = $(this.verseSelect).val();
    const sura = $(this.suraSelect).val();

    if (sura === undefined || verse === undefined) {
      console.error('Sura or Verse is undefined');
      return;
    }

    fetchJsonData(
      Routes.maxWords,
      (maxWords: Record<number, Record<number, number[]>>) => {
        $(this.verseSelect).find('option').remove().end();
        const maxVerse = Object.keys(maxWords[+sura]).length;
        $.each(this.makeVerseOptions(maxVerse), (index, option)=>{
          $(this.verseSelect).append(option);
        })
        if (clearVerse) {
          $(this.verseSelect).val(-1).trigger('change');
        } else {
          $(this.verseSelect).val(verse);
        }
      },
    );
  }

  private setArabWord() {
    const arab = $(this.wordSelect).find(':selected' as string).attr('data-arab');
    const arabText = $(this.wordSelect).parent().children('.arab-word');
    console.log('Setting arab word');
    if (arab) {
      arabText.text(arab);
    } else {
      arabText.html('&nbsp;');
    }
  }
  private setWords(words: QuranWord[], clearWord: boolean = false) {
    const word = $(this.wordSelect).val();
    $(this.wordSelect).find('option').remove().end();
    $.each(this.makeWordOptions(words), (index, word)=>{
      $(this.wordSelect).append(word);
    });

    if(clearWord){
      console.log("Setting the selected to ", words[0].wort);
      $(this.wordSelect).val(words[0].wort);
    }
    else{
      $(this.wordSelect).val(word ? word : 0);
    }
    this.setArabWord();
  }

  private changeWordDropdown(clearWord: boolean = true) {
    if(this.wordSelect.length == 0){
      return;
    }
    console.log('Changing word dropdown');

    const sura = $(this.suraSelect).val();
    const verse = $(this.verseSelect).val();
    console.log(verse);

    if (!verse) {
      console.log('Removing all options');
      $(this.wordSelect).find('option').remove().end();
      this.setArabWord();
    } else if (sura && verse) {
      fetchJsonData(Routes.quranWords(+sura, +verse), (data: QuranWord[]) => {
        this.setWords(data, clearWord);
      });
    }
  }
}
