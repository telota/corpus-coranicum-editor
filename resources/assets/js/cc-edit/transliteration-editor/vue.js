// Create a new Vue instance
import Buttons from './summerNoteButtons';
import Words from './words';
import Lines from './lines';
import TagHelper from './tagHelper';

const tagSetter = require('./tagSetter');
const tagFormatter = require('tag-denestify/tag-formatter');

let code;
let me;

const summernoteComponent = {
  replace: true,
  inherit: false,
  template: "<textarea class='form-control' :name='name'></textarea>",
  props: {
    language: {
      type: String,
      required: false,
      default: 'en-US',
    },
    height: {
      type: Number,
      required: false,
      default: 80,
    },
    minHeight: {
      type: Number,
      required: false,
      default: 80,
    },
    maxHeight: {
      type: Number,
      required: false,
      default: 500,
    },
    name: {
      type: String,
      required: false,
      default: '',
    },

    toolbar: {
      type: Array,
      required: false,
      default() {
        return [
          [
            'style',
            [
              'erased',
              'modified',
              'variant',
              'added',
              'omitted',
              'unclear',
              'illegible',
              'standard',
            ],
          ],
        ];
      },
    },
  },
  created() {
    this.isChanging = false;
    this.control = null;
  },
  mounted() {
    //  initialize the summernote
    if (this.minHeight > this.height) {
      this.minHeight = this.height;
    }
    if (this.maxHeight < this.height) {
      this.maxHeight = this.height;
    }
    me = this;
    this.control = $(this.$el);
    this.control.summernote({
      lang: this.language,
      height: this.height,
      minHeight: this.minHeight,
      maxHeight: this.maxHeight,
      toolbar: this.toolbar,
      buttons: {
        omitted: Buttons.omittedButton,
        unclear: Buttons.unclearButton,
        illegible: Buttons.illegibleButton,
        added: Buttons.addedButton,
        modified: Buttons.modifiedButton,
        variant: Buttons.variantButton,
        erased: Buttons.erasedButton,
        standard: Buttons.standardButton,
      },
      disableDragAndDrop: true,
      direction: 'rtl',
      disableResizeEditor: true,
      callbacks: {
        onChange() {
          if (!me.isChanging) {
            me.isChanging = true;
            code = me.control.summernote('code');
            me.$nextTick(() => {
              me.isChanging = false;
            });
          }
          for (let i = 0; i < me.$parent.lineList.length; i += 1) {
            if (
              me.$parent.lineList[i].isActive &&
              me.$parent.lineList[i].editedText !== ''
            ) {
              Words.saveWords(me.$parent.lineList[i]);
            }
          }
          me.$parent.text = code;
        },
      },
    });
  },
};

let lineList = {
  template: '<div></div>',
  props: ['currentLineList'],
};

if ($('body').find('#transliterationEditor').length > 0) {
  new Vue({
    el: '#transliterationEditor',
    data: {
      // start with already one (active) line
      lineList: [],
      selectedOption: 2,
      deletedLine: new Lines.Line(0),
    },

    components: {
      editor: summernoteComponent,
      'line-list': lineList,
    },

    mounted() {
      const dataBaseLines = this.$refs.lines.$options.propsData.currentLineList;
      if (dataBaseLines.length < 1) {
        this.lineList = [new Lines.Line(1)];
        this.lineList[0].setIsActive(true);
      } else {
        for (let i = 0; i < dataBaseLines.length; i += 1) {
          this.lineList.push(
            new Lines.Line(
              dataBaseLines[i].linenumber,
              dataBaseLines[i].HTML,
              dataBaseLines[i].XML,
            ),
          );
          const line = this.lineList[this.lineList.length - 1];
          //set Words per Line in Linelist
          // format the string
          if (!/<l n=".[^<]*"><\/l>/.test(dataBaseLines[i].HTML)) {
            const formattedTag = TagHelper.deleteDoubleTags(
              tagFormatter.formatTagString(dataBaseLines[i].HTML, ['w', 'pc']),
            );

            const deleteTagsReg = new RegExp('(<\\/?[^>]+(>|$))|&nbsp;', 'g');

            // get an array of all the words (throw away the  tags from the string)
            const allWords = formattedTag
              .replace(deleteTagsReg, '')
              .split(/\s/g);

            let words = [];

            for (let i = 0; i < allWords.length; i += 1) {
              if (allWords[i].length > 0) {
                words.push(allWords[i]);
              }
            }
            // get the word-ids from the words that are currently saved in line
            // (for if words are overwritten etc.)
            const wordCount = tagSetter.getWordCountArray(line.editedText);

            // delete all empty words / words that are just a space
            words = words.filter(word => {
              if (word.length > 0 && !/\s/.test(word)) {
                return word;
              }
            });

            for (let i = 0; i < words.length; i += 1) {
              line.getWords().push(new Words.Word(wordCount[0], words[i]));
              wordCount.splice(0, 1);
            }
          } else {
            line.setWords([]);
          }
        }
        this.selectedOption = this.lineList.length + 1;
      }
    },

    methods: {
      /**
       * adds a word to active line
       * @param {Word} word that shall be added
       */
      addWordToLine(word) {
        let wordnumber = word.sure + ':' + word.vers + ':' + word.wort;
        // search for active Line, add word, update summernote-content
        for (let i = 0; i < this.lineList.length; i += 1) {
          if (this.lineList[i].isActive) {
            this.lineList[i].addWord(new Words.Word(wordnumber, word.arab));
            $('#transliterationSummernote').summernote(
              'code',
              this.lineList[i].getWordString(),
            );
          }
        }
      },

      /**
       * removes word & wordStyle from active line
       * @param {Word} word that shall be removed
       */
      deleteWordFromLine(word) {
        // search for active Line, remove word
        for (let i = 0; i < this.lineList.length; i += 1) {
          if (this.lineList[i].isActive) {
            this.lineList[i].deleteWord(word);
          }
        }
      },

      /**
       * sets currently active line (if exists) inactive and activates given line
       * @param {Line} line that shall be set active
       */
      setLineActive(line) {
        // searching for any active line and deactivate it
        for (let i = 0; i < this.lineList.length; i += 1) {
          if (this.lineList[i].isActive && this.lineList[i] !== line) {
            this.setLineInactivate(this.lineList[i]);
          }
        }
        line.setIsActive(true);
        // update summernote content with active lines content
        $('#transliterationSummernote').summernote(
          'code',
          line.getWordString(),
        );
      },

      /**
       * Deactivate currently active Line
       * @param {Line} line that shall be set inactive
       */
      setLineInactivate(line) {
        try {
          if (line.hasError)
            throw [
              'Line number ' +
                line.number +
                ' contains an Error ' +
                'in the wordcount. Please redo it.',
              line.editedText,
            ];
          line.setIsActive(false);
          line.setIsEdited(true);
          // clear out summernote-content (reason: no active line)
          $('#transliterationSummernote').summernote('code', '');
          // set Line-Tags
          tagSetter.setLineTags(line);
          line.xmlText = line.getEditedText().replace(/class=".[^"]*"/g, '');
        } catch (error) {
          $('#errorInLineModal').modal('toggle');
          $('#undefinedWordError').text(error[0]);
          $('#errorLine').html(error[1]);
          console.log(error);
        }
      },

      /**
       * deletes complete line and its contents, and deactivates/saves currently active line
       * @param {Line} line that shall be deleted
       */
      deleteLine(line) {
        // deactivating active line
        for (let i = 0; i < this.lineList.length; i += 1) {
          if (this.lineList[i].isActive) {
            this.setLineInactivate(this.lineList[i]);
          }
        }
        // delete line from list of lines
        this.lineList.splice(this.lineList.indexOf(line), 1);
        // Update all other line-numbers/ID's
        for (let i = 0; i < this.lineList.length; i += 1) {
          this.lineList[i].number = i + 1;
          tagSetter.setLineTags(this.lineList[i]);
        }
        // Update dropdown-menu for line-insertion to newest next Line-Index
        this.selectedOption = this.lineList.length + 1;
      },

      /**
       * saves line that user wants to delete for Popup asking for users reassurance
       * @param {Line} line that shall be deleted
       */
      setDeletionData(line) {
        this.deletedLine = line;
        if (line.isActive) {
          this.setLineInactivate(line);
        }
      },

      /**
       * adds new line to user-selected position
       * @param {int} selectedOption is position user wants to inser new line at
       */
      addLine(selectedOption) {
        // search for active line and deactivate it
        for (let i = 0; i < this.lineList.length; i += 1) {
          if (this.lineList[i].isActive) {
            this.setLineInactivate(this.lineList[i]);
          }
        }
        // selectedOption starts at 1, array-indices at 0 (insert new line at selected position)
        // new line is always active
        this.lineList.splice(
          selectedOption - 1,
          0,
          new Lines.Line(selectedOption),
        );
        this.lineList[selectedOption - 1].setIsActive(true);
        // Update all lines in line-list to new line numbers/ID's
        for (let i = 0; i < this.lineList.length; i += 1) {
          this.lineList[i].number = i + 1;
          tagSetter.setLineTags(this.lineList[i]);
        }
        // Update dropdown-menu for line-insertion to newest next Line-Index
        this.selectedOption = this.lineList.length + 1;
        $('#transliterationSummernote').summernote('code', '');
      },

      /**
       * check if any line is active (For disabling adding words to any line)
       * @returns {boolean} true if any line is active
       */
      isActiveLine() {
        for (let i = 0; i < this.lineList.length; i += 1) {
          if (this.lineList[i].isActive) {
            return true;
          }
        }
        return false;
      },

      saveAllLines(manuscript_page_id) {
        try {
          for (let i = 0; i < this.lineList.length; i += 1) {
            if (this.lineList[i].hasError)
              throw [
                'Line number ' +
                  this.lineList[i].number +
                  ' contains an Error ' +
                  'in the wordcount. Please redo it.',
                this.lineList[i].editedText,
              ];
            if (this.lineList[i].isActive) {
              this.setLineInactivate(this.lineList[i]);
            }
          }
          const instance = this;
          axios
            .post('manuskriptseiten/edit-transliteration/store', {
              lineList: instance.lineList,
              manuscript_page_id: manuscript_page_id,
            })
            .then(response => {
              window.location.href = response.request.responseURL;
            })
            .catch(err => console.error(err));
        } catch (error) {
          $('#errorInLineModal').modal('toggle');
          $('#undefinedWordError').text(error[0]);
          $('#errorLine').html(error[1]);
        }
      },
    },
  });
}
if ($('body').find('#showTransliterations').length > 0) {
  new Vue({
    el: '#showTransliterations',
  });
}
