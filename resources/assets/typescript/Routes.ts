export class Routes {
  static readonly maxWords = `/quran/maxWords`;
  public static newMapping(verseOnly: boolean = true){
    if(verseOnly){
      return '/intertext/new-mapping'
    }
    return `/manuscript-page/new-mapping`;
  }
  public static quranWords(sura: number, verse: number) {
    return `/quran/sura/${sura}/verse/${verse}`;
  }

  public static variantsForm(sura: number, verse: number){
    return `/reading-variants/sura/${sura}/verse/${verse}`;

  }
}
