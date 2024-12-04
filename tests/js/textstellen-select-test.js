import test from 'ava';
import { mount } from 'vue-test-utils';
import axios from 'axios';
import { axiosConfig } from '../../resources/assets/js/components/variables';
import TextstellenSelect from '../../resources/assets/js/cc-edit/textstellen/TextstellenSelect.vue';

test.beforeEach((t) => {
  t.context.wrapper = mount(TextstellenSelect);
  t.context.wrapper.update();
});

test('it has sura lists that contain all 114 suras', (t) => {
  t.is(114, t.context.wrapper.vm.allSuras.length);
  t.is(1, t.context.wrapper.vm.allSuras[0]);
  t.is(114, t.context.wrapper.vm.allSuras.pop());
});

test('it has all 114 suras in the dropdown selects', (t) => {
  const suraStartSelect = t.context.wrapper.find('#sura-start');
  const suraEndSelect = t.context.wrapper.find('#sura-end');

  t.true(suraStartSelect.contains('option'));
  t.true(suraEndSelect.contains('option'));

  t.is(114, suraStartSelect.findAll('option').length);
  t.is(114, suraEndSelect.findAll('option').length);
});

test('it can get the maximum verse number of a given sura', async (t) => {
  const http = axios.create(axiosConfig);

  const verse = await http.get('get-verses', {
    params: {
      sure: 1,
    },
  })
    .then(response => response.data);

  t.is(verse.length, 7);
});

test('it fetches the correct number of verses for a given sura', async (t) => {
  const versesSura1 = await t.context.wrapper.vm.numberOfVerses(1);
  const versesSura2 = await t.context.wrapper.vm.numberOfVerses(2);
  const versesSura114 = await t.context.wrapper.vm.numberOfVerses(114);

  t.is(7, versesSura1.length);
  t.is(286, versesSura2.length);
  t.is(6, versesSura114.length);
});

test('it updates the computed list of available verses per start sura', async (t) => {
  await t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraStart, 'start').then(() => {
    t.is(7, t.context.wrapper.vm.availableVersesStart.length);
  });

  t.context.wrapper.vm.suraStart = 2;
  t.context.wrapper.update();

  await t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraStart, 'start').then(() => {
    t.is(286, t.context.wrapper.vm.availableVersesStart.length);
  });
});

test('it renders a list of all available verses in a given ending sura', async (t) => {
  t.true(t.context.wrapper.contains('#verse-start'));

  await t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraStart, 'start').then(() => {
    const verseStart = t.context.wrapper.find('#verse-start');
    t.true(verseStart.contains('option'));
    t.is(7, verseStart.findAll('option').length);
  });

  t.context.wrapper.vm.suraStart = 2;
  t.context.wrapper.update();

  await t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraStart, 'start').then(() => {
    const verseStart = t.context.wrapper.find('#verse-start');
    t.true(verseStart.contains('option'));
    t.is(286, verseStart.findAll('option').length);
  });
});

test('it updates the computed list of available verses per end sura', async (t) => {
  await t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraEnd, 'end').then(() => {
    t.is(6, t.context.wrapper.vm.availableVersesEnd.length);
  });

  t.context.wrapper.vm.suraEnd = 2;
  t.context.wrapper.update();

  await t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraEnd, 'end').then(() => {
    t.is(286, t.context.wrapper.vm.availableVersesEnd.length);
  });
});

test('it renders a list of all available verses in a given ending sura', async (t) => {
  t.true(t.context.wrapper.contains('#verse-end'));

  t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraEnd, 'end').then(() => {
    const verseEnd = t.context.wrapper.find('#verse-end');
    t.true(verseEnd.contains('option'));
    t.is(7, verseEnd.findAll('option').length);
  });

  t.context.wrapper.vm.suraEnd = 2;
  t.context.wrapper.update();

  t.context.wrapper.vm.numberOfVerses(t.context.wrapper.vm.suraEnd, 'end').then(() => {
    const verseEnd = t.context.wrapper.find('#verse-end');
    t.true(verseEnd.contains('option'));
    t.is(286, verseEnd.findAll('option').length);
  });
});

test('it resets the verse and word counter when the start sura is changed', (t) => {
  t.context.wrapper.vm.verseStart = 2;
  t.context.wrapper.vm.wordStart = 3;

  t.context.wrapper.vm.suraStart = 2;
  t.context.wrapper.vm.updateVersesStart();
  t.context.wrapper.update();

  t.is(1, t.context.wrapper.vm.verseStart);
  t.is(1, t.context.wrapper.vm.wordStart);
});


test('it resets the verse and word counter when the end sura is changed', (t) => {
  t.context.wrapper.vm.verseEnd = 2;
  t.context.wrapper.vm.wordEnd = 3;

  t.context.wrapper.vm.suraEnd = 2;
  t.context.wrapper.vm.updateVersesEnd();
  t.context.wrapper.update();

  t.is(1, t.context.wrapper.vm.verseEnd);
  t.is(1, t.context.wrapper.vm.wordEnd);
});

test('it updates the list of available words in a given start verse', async (t) => {
  await t.context.wrapper.vm.wordsForVerse(t.context.wrapper.vm.suraStart, t.context.wrapper.vm.verseStart, 'start').then(() => {
    t.is(4, t.context.wrapper.vm.availableWordsStart.length);
  });

  t.context.wrapper.vm.suraStart = 2;
  t.context.wrapper.update();

  t.context.wrapper.vm.verseStart = 2;
  t.context.wrapper.update();

  await t.context.wrapper.vm.wordsForVerse(t.context.wrapper.vm.suraStart, t.context.wrapper.vm.verseStart, 'start').then(() => {
    t.is(7, t.context.wrapper.vm.availableWordsStart.length);
  });
});

test('it updates the list available words in a given ending verse', async (t) => {
  await t.context.wrapper.vm.wordsForVerse(t.context.wrapper.vm.suraEnd, t.context.wrapper.vm.verseEnd, 'end').then(() => {
    t.is(4, t.context.wrapper.vm.availableWordsEnd.length);
  });

  t.context.wrapper.vm.suraEnd = 2;
  t.context.wrapper.update();

  t.context.wrapper.vm.verseEnd = 2;
  t.context.wrapper.update();

  await t.context.wrapper.vm.wordsForVerse(t.context.wrapper.vm.suraEnd, t.context.wrapper.vm.verseEnd, 'end').then(() => {
    t.is(7, t.context.wrapper.vm.availableWordsEnd.length);
  });
});
