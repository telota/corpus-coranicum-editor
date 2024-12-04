import TagHelper from './tagHelper';

const tagSetter = require('./tagSetter');
const tagFormatter = require('tag-denestify/tag-formatter');

/**
 * Word Object, consisting of a number/ID and a text
 */
class Word {
  constructor(number, text) {
    this.number = number;
    this.text = text;
  }
}

/**
 * Method for saving words from editor to selected line
 * @param {Line} line that the words shall be written into
 */
const saveWords = function(line) {
  if (/.*/.test($('#transliterationSummernote').summernote('code'))) {
    // get the contents from summernote-editor
    const editorText = $('#transliterationSummernote')
      .summernote('code')
      .replace(/&nbsp;|<br>/g, '');

    // format the string
    const formattedTag = TagHelper.deleteDoubleTags(
      tagFormatter.formatTagString(editorText, ['w', 'pc']),
    );

    const deleteTagsReg = new RegExp('(<\\/?[^>]+(>|$))|&nbsp;', 'g');

    // get an array of all the words (throw away the  tags from the string)
    const allWords = formattedTag.replace(deleteTagsReg, '').split(/\s/g);

    let words = [];
    // is true, when the line-text / editorText contains "۝"
    let containsVerseSeperator = false;

    for (let i = 0; i < allWords.length; i += 1) {
      if (allWords[i].length > 0) {
        words.push(allWords[i]);
        if (/۝/.test(allWords[i])) {
          containsVerseSeperator = true;
        }
      }
    }
    const wordCountArray = [];
    // get the word-ids from the words that are currently saved in line
    // (for if words are overwritten etc.)
    for (let i = 0; i < line.words.length; i += 1) {
      wordCountArray.push(line.words[i].number);
    }

    line.setEditedText(
      tagSetter.setWordTags(words, formattedTag, wordCountArray),
    );

    // delete all empty words / words that are just a space
    words = words.filter(word => {
      if (word.length > 0 && !/\s/.test(word)) {
        return word;
      }
    });

    // get newly assigned wordIds
    const wordCount = tagSetter.getWordCountArray(line.editedText);

    //check for undefined wordnumbers (errors)
    let internalLineError = false;
    for (let i = 0; i < wordCount.length; i += 1) {
      if (wordCount[i] === 'undefined') {
        internalLineError = true;
      }
    }

    if (internalLineError) {
      line.hasError = true;
    } else {
      line.hasError = false;
    }

    // delete old wordcontents from line
    line.setWords([]);

    // fill line with the current words
    for (let i = 0; i < words.length; i += 1) {
      line.getWords().push(new Word(wordCount[0], words[i]));
      wordCount.splice(0, 1);
    }
  }
};

export default {
  Word,
  saveWords,
};
