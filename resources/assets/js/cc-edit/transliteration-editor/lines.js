const tagSetter = require('./tagSetter');

/**
 * Line Object consisting of a number/ID and an Array of words
 * May be edited (has an editedText of type string formed out of the words), and active/inactive
 */
class Line {
  constructor(number, editedText, xmlText) {
    this.number = number;

    this.words = [];
    this.verseSeperators = [];
    this.tempWordArray = [];

    this.isActive = false;
    this.isEdited = false;

    if (editedText === undefined) {
      this.editedText = '';
    } else {
      this.editedText = editedText;
    }
    if (xmlText === undefined) {
      this.xmlText = '';
    } else {
      this.xmlText = xmlText;
    }

    this.hasError = false;
  }

  // getter & setter
  getNumber() {
    return this.number;
  }
  setNumer(val) {
    this.number = val;
  }

  getWords() {
    return this.words;
  }
  setWords(val) {
    this.words = val;
  }

  getTempWordArray() {
    return this.tempWordArray;
  }
  setTempWordArray(val) {
    this.tempWordArray = val;
  }

  getIsActive() {
    return this.isActive;
  }
  setIsActive(val) {
    this.isActive = val;
  }

  getIsEdited() {
    return this.isEdited;
  }
  setIsEdited(val) {
    this.isEdited = val;
  }

  getEditedText() {
    return this.editedText;
  }
  setEditedText(val) {
    this.editedText = val;
  }

  addWord(word) {
    this.words.push(word);
    this.tempWordArray.push(word);
  }

  /**
   * delete a word from the line
   * @param {Word} word that needs to be deleted
   */
  deleteWord(word) {
    // contains all Words/wordparts from tag/wordString + index in Array with words and tags
    const tempArray = [];
    // String for checking if parts of a word are the full word
    let matchString = '';
    // Array containing arrays with indexes from wordparts grouped into words:
    // ["He", "llo", "World"] -> [[0,1],[2]]
    const finishedArray = [];
    let isMatchString = false;
    // Array containing all words + tags from String
    const wordTagArray = [];

    // delete all empty Tags from editedText
    this.editedText = $('#transliterationSummernote')
      .summernote('code')
      .replace(/<[^<|>|/]*><\/[^<|>]*>/g, '');

    const editedTextArray = this.editedText.split(/(<.*?>)/g);

    for (let i = 0; i < editedTextArray.length; i += 1) {
      if (
        /<[^/].*>/.test(editedTextArray[i]) ||
        /<\/.*>/.test(editedTextArray[i])
      ) {
        wordTagArray.push(editedTextArray[i]);
      } else {
        const splitArray = editedTextArray[i].split(/(\s)/g);
        for (let j = 0; j < splitArray.length; j += 1) {
          if (splitArray[j].length > 0) {
            wordTagArray.push(splitArray[j]);
          }
        }
      }
    }

    // fill Array with all the words / wordparts
    for (
      let wordTagArrayIndex = 0;
      wordTagArrayIndex < wordTagArray.length;
      wordTagArrayIndex += 1
    ) {
      if (
        !(
          /<[^/].*>/.test(wordTagArray[wordTagArrayIndex]) ||
          /<\/.*>/.test(wordTagArray[wordTagArrayIndex])
        )
      ) {
        tempArray.push([wordTagArray[wordTagArrayIndex], wordTagArrayIndex]);
      }
    }

    // look at all the words in the Words-Array
    for (let wordsIndex = 0; wordsIndex < this.words.length; wordsIndex += 1) {
      isMatchString = false;
      // look at Word/wordpart Array and combine parts until you got a matching word
      for (let tempIndex = 0; !isMatchString; tempIndex += 1) {
        if (!/\s/.test(tempArray[tempIndex])) {
          matchString += tempArray[tempIndex][0];

          if (matchString === this.words[wordsIndex].text) {
            // Array for Indices from the corresponding word-parts
            const numberArray = [];
            for (let j = 0; j <= tempIndex; j += 1) {
              numberArray.push(tempArray[j][1]);
            }
            finishedArray.push(numberArray);
            tempArray.splice(0, tempIndex + 1);
            isMatchString = true;
            matchString = '';
          }
        }
      }
    }

    for (let i = 0; i < finishedArray.length; i += 1) {
      if (i === this.words.indexOf(word)) {
        for (let j = finishedArray[i].length - 1; j >= 0; j -= 1) {
          wordTagArray.splice(finishedArray[i][j], 1);
        }
      }
    }

    this.editedText = wordTagArray
      .join('')
      .replace(/<[^<|>|/]*><\/[^<|>]*>/g, '');
    this.words.splice(this.words.indexOf(word), 1);
    $('#transliterationSummernote').summernote('code', this.editedText);
  }

  /**
   * sets generated the editedText from the added words (words[])
   * @returns {string|*|string}
   */
  getWordString() {
    const wordArray = [];
    let wordCountArray = [];
    if (this.tempWordArray.length > 0) {
      for (let i = 0; i < this.tempWordArray.length; i += 1) {
        wordArray.splice(0, 0, this.tempWordArray[i].text);
        wordCountArray.splice(0, 0, this.tempWordArray[i].number);
      }
      if (this.editedText === '') {
        this.editedText = `${tagSetter.setWordTags(
          wordArray,
          wordArray.join(' '),
          wordCountArray,
        )}`;
      } else {
        this.editedText = `${this.editedText} 
        ${tagSetter.setWordTags(
          wordArray,
          wordArray.join(' '),
          wordCountArray,
        )}`;
      }
      wordCountArray = [];
      this.tempWordArray = [];
    } else if (this.tempWordArray.length > 0 && !this.isEdited) {
      for (let i = 0; i < this.words.length; i += 1) {
        wordArray.splice(0, 0, this.words[i].text);
        wordCountArray.splice(0, 0, this.words[i].number);
      }
      wordCountArray = [];
      this.editedText = tagSetter.setWordTags(
        wordArray,
        wordArray.join(' '),
        wordCountArray,
      );
    }
    return this.editedText;
  }
}

export default {
  Line,
};
