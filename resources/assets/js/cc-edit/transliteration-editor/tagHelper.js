const tagFormatter = require('tag-denestify/tag-formatter');
/**
 * deletes same sytle-tags which are immediately next to each other: <t>he</t><t>llo</t> => <t>hello</t>
 * @param string string with same style-tags
 * @returns {string} reduced string
 */
const deleteDoubleTags = string => {
  const reg = new RegExp('(<.*?>)', 'g');
  let lastOpeningTag = '';

  const contentArray = string
    .split(/<p[^c|>]*>|<\/p>|<\/l>|<l[^>]*>/g)
    .join('')
    .split(reg)
    .filter(value => value.length > 0);

  for (let i = 0; i < contentArray.length; i += 1) {
    if (
      contentArray[i] === lastOpeningTag &&
      /<\/.*>/.test(contentArray[i - 1])
    ) {
      contentArray.splice(i - 1, 2);
      i -= 2;
    } else if (/<[^/].*>/.test(contentArray[i])) {
      lastOpeningTag = contentArray[i];
    }
  }
  return contentArray.join('');
};

/**
 * deletes "<standard>"-tags
 * @param string string with standard tags
 * @returns {string} cleaned up string
 */
const deleteStandardTags = string => {
  const tempString = tagFormatter.formatTagString(string);
  return tempString.split(/<standard>|<\/standard>/g).join('');
};

export default {
  deleteDoubleTags,
  deleteStandardTags,
};
