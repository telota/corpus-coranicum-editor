/**
 * deletes <w> and <pc> tags from string, and splits into Array with tags,
 * whitespaces and words as standalone elements
 * @param string whole string including all words and set tags
 * @returns {Array} Array with tags, whitespaces and words as standalone elements
 */
const convertStringToArray = string => {
  const newString = string
    .split(/<w[^>]*>|<\/w>|<pc[^>]*>|<\/pc>|<p[^>]*>|<\/p>|<\/l>|<l[^>]*>/g)
    .join('');
  const tempTagArray = newString.split(/(<.*?>)/g);
  const wordTagArray = [];

  for (let i = 0; i < tempTagArray.length; i += 1) {
    if (/<[^/].*>/.test(tempTagArray[i]) || /<\/.*>/.test(tempTagArray[i])) {
      wordTagArray.push(tempTagArray[i]);
    } else {
      const splitArray = tempTagArray[i].split(/(\s)/g);
      for (let j = 0; j < splitArray.length; j += 1) {
        if (splitArray[j].length > 0 && !/\s/.test(splitArray[j])) {
          wordTagArray.push(splitArray[j]);
        }
      }
    }
  }

  return wordTagArray;
};
/**
 * gets all word-Ids from a string of Tags
 * ("<w n=000:000:001">Hello</w><w n="000:000:002">World</w>) => ["000:000:001","000:000:002"]
 * @param {string} string with w
 * @returns {Array|{index: number, input: string}}
 */
const getWordCountArray = string => {
  if (string !== '') {
    const tempString = string.match(/<w[^>]*>|<pc[^>]*>/g).join('');
    if (tempString.indexOf('"') > -1) {
      const tempString2 = tempString.match(/".[^"]*"/g).join('');
      let tempArray = tempString2.match(/[^"].[^"]*[^"]/g);
      tempArray = tempArray.filter(el => el.length > 0);
      return tempArray;
    }
  }
};

const getOpeningTagName = tagElement => {
  // if tagArray[i] is an opening tag
  const regOpening = new RegExp('<|>');
  return tagElement.split(regOpening)[1].split(' ')[0];
};

/**
 * get TagName from closing-tag
 * @param tagElement
 * @returns string TagName
 */
const getClosingTagName = tagElement => {
  // if tagArray[i] is a closing tag
  const regClosing = new RegExp('<\\/|>');
  return tagElement.split(regClosing)[1];
};

/**
 * sets <w>-tags around words and adds missing tags
 * @param wordArray Array containing complete words
 * @param tagString String with tags
 * @returns {string} a string with correctly placed w-tags
 */
const setWordTags = (wordArray, tagString, countArray) => {
  // Split string into tags with Arrays
  const wordTagArray = convertStringToArray(tagString);

  let wordCountArray = countArray;

  if (
    (typeof wordCountArray === 'undefined' || wordCountArray === null) &&
    tagString !== ''
  ) {
    wordCountArray = getWordCountArray(tagString);
  }

  let wTagCount = 0;
  const wTagArray = tagString.split(/(<.[^/|<]*>|<\/.*>)/g);

  if (wTagArray !== 'undefined' && wTagArray !== null) {
    for (let i = 0; i < wTagArray.length; i += 1) {
      if (/<w n=".*">/.test(wTagArray[i]) || /<pc>/.test(wTagArray[i])) {
        wTagCount += 1;
      }
    }
  }

  let matchString = '';

  const openedTagArray = [];
  const finishedArray = [];
  let tempArray = [];

  let isMatchString = false;
  let isVerseSeperator = false;
  let isNotSplit = false;

  let countIndex = 0;

  for (let wordIndex = 0; wordIndex < wordArray.length; wordIndex += 1) {
    isMatchString = false;
    isVerseSeperator = false;

    // tinker on matchString as long as it isn't a complete Word
    // wordTagArray= ["He""<t>""llo""</t>"], matchString = "He" -> "Hello"
    for (let wordTagIndex = 0; !isMatchString; wordTagIndex += 1) {
      if (matchString === wordArray[wordIndex]) {
        if (
          wTagArray !== null ||
          wTagArray !== 'undefined' ||
          wTagArray.length !== 0
        ) {
          // checks if there are more / less wordTags than words
          // can happen if a word was split(less wTags than words) or more than one were marked
          if (wTagCount !== wordArray.length && wordArray.length > 1) {
            let lastOpenedTag = '';
            for (
              let wTagArrayIndex = 0;
              wTagArrayIndex < wTagArray.length;
              wTagArrayIndex += 1
            ) {
              isNotSplit = false;
              if (/<w n=".*">/.test(wTagArray[wTagArrayIndex])) {
                // is the last opened word-Tag. Important for word-ID
                lastOpenedTag = wTagArray[wTagArrayIndex];
                for (let i = wTagArrayIndex + 1; !isNotSplit; i += 1) {
                  const openedTags = [];
                  if (/<\/w>/.test(wTagArray[i])) {
                    isNotSplit = true;
                  } else if (
                    /<[^/].*>/.test(wTagArray[i]) &&
                    !/<w n=".*">/.test(wTagArray[i])
                  ) {
                    openedTags.push(wTagArray[i]);

                    // checks if there is nonTag element with spaces following an opening word-tag
                    // it means a word was split and needs newly set w-tags with the same ID it had
                    // before it was split
                    // <w n="1">Hello</w> => <w n="1">Hel</w><w n="1">lo</w>
                  } else if (
                    !/<.*>/.test(wTagArray[i]) &&
                    wTagArray[i] !== ' ' &&
                    wTagArray[i].indexOf(' ') > -1
                  ) {
                    // array containing both word parts Hel lo => ["Hel","lo"]
                    const wTempArray = wTagArray[i].split(/\s*/);
                    wTagArray[i] = wTempArray[0];
                    i += 1;

                    // closes all tags that belonged to the whole word
                    // and therefor to the split as well
                    for (let k = 0; k < openedTags.length; k += 1) {
                      wTagArray.splice(
                        i + k,
                        0,
                        `</${getClosingTagName(openedTags[k])}>`,
                      );
                    }
                    i += openedTags.length;

                    // closes the opened word Tag and opens a new one with the same ID
                    wTagArray.splice(i, 0, '</w>');
                    wTagArray.splice(i + 1, 0, lastOpenedTag);

                    i += 2;

                    // sets all opened tag that belonged to the whole word
                    // and therefor to the split as well
                    for (let k = 0; k < openedTags.length; k += 1) {
                      wTagArray.splice(i + k, 0, openedTags[k]);
                    }
                    i += openedTags.length;
                    // inserts second half of the split word
                    wTagArray.splice(i, 0, wTempArray[1]);

                    // important for the ID's
                    // (Ids are read and assigned to words from wordCountArray)
                    wordCountArray = getWordCountArray(wTagArray.join(''));
                  }
                }
              }
            }
          }
        }

        if (/<\/.*>/.test(wordTagArray[wordTagIndex])) {
          wordTagIndex += 1;
        }

        // add everything in the wordTagArray until matchPoint to new Array
        for (let i = 0; i < wordTagIndex; i += 1) {
          tempArray.push(wordTagArray[i]);
        }

        wordTagArray.splice(0, wordTagIndex);

        // Check if the Word is a verseseperator or true word
        if (!/\s/.test(matchString)) {
          if (/۝/.test(matchString)) {
            isVerseSeperator = true;
          }

          if (openedTagArray.length > 0) {
            for (let i = 0; i < openedTagArray.length; i += 1) {
              // openedTagArray[i][1] = false, when no closing tag exists
              // (attribute tag is covering more than one word)
              if (!openedTagArray[i][1]) {
                tempArray.splice(0, 0, openedTagArray[i][0]);
              }
            }
          }

          for (
            let tempIndex = 0;
            tempIndex < tempArray.length;
            tempIndex += 1
          ) {
            // test if every opening tag has a matching closing tag
            // if so, delete from openedTagArray
            if (/<[^/].*>/.test(tempArray[tempIndex])) {
              for (let i = tempIndex; i < tempArray.length; i += 1) {
                if (/<\/.*>/.test(tempArray[i])) {
                  for (let j = 0; j < openedTagArray.length; j += 1) {
                    if (
                      getOpeningTagName(openedTagArray[j][0]) ===
                      getClosingTagName(tempArray[i])
                    ) {
                      openedTagArray.splice(j, 1);
                    }
                  }
                }
              }
            }
          }
          if (openedTagArray.length > 0) {
            for (let i = 0; i < openedTagArray.length; i += 1) {
              tempArray.push(`</${getOpeningTagName(openedTagArray[i][0])}>`);
              openedTagArray[i][1] = false;
            }
          }
          if (isVerseSeperator) {
            const pcTag = document.createElement('pc');
            pcTag.setAttribute('n', wordCountArray[countIndex]);
            pcTag.innerHTML = tempArray.join('');
            finishedArray.push(pcTag.outerHTML);
          } else {
            const wordTag = document.createElement('w');
            wordTag.setAttribute('n', wordCountArray[countIndex]);
            wordTag.innerHTML = tempArray.join('');
            finishedArray.push(wordTag.outerHTML);
          }
          countIndex += 1;
        }

        matchString = '';
        tempArray = [];

        isMatchString = true;
      }
      if (/<[^/].*>/.test(wordTagArray[wordTagIndex]) && !isMatchString) {
        openedTagArray.push([wordTagArray[wordTagIndex], true]);
      } else if (
        !/<[^/].*>/.test(wordTagArray[wordTagIndex]) &&
        !/<\/.*>/.test(wordTagArray[wordTagIndex]) &&
        !isMatchString
      ) {
        matchString += wordTagArray[wordTagIndex];
      }
    }
  }
  return finishedArray.join(' ');
};

/**
 * sets appropiate line-Tags with line-number around the string
 * @param line
 */
const setLineTags = line => {
  const lineTag = document.createElement('l');
  lineTag.setAttribute('n', line.number);
  lineTag.innerHTML = line.editedText.replace(/<\/l>|<l[^>]*>/g, '');
  line.setEditedText(lineTag.outerHTML);
};

module.exports = {
  convertStringToArray,
  setWordTags,
  getWordCountArray,
  setLineTags,
};
