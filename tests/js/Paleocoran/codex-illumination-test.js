/**
 * If not done already, execute
 * $ php artisan db:seed --class=JsTestSeeder
 * beforehand to provide some example data
 */

import test from 'ava';
import Vue from 'vue';
import faker from 'faker';
import IlluminationList from '../../../resources/assets/js/cc-edit/codex-illumination/IlluminationList.vue';
import Illumination from '../../../resources/assets/js/cc-edit/codex-illumination/Illumination.vue';
import IlluminationModal from '../../../resources/assets/js/cc-edit/codex-illumination/IlluminationModal.vue';
import CodexIllumination from '../../../resources/assets/js/cc-edit/codex-illumination/codex-illumination';

let vmList;
let vmSingle;
let vmModal;
let testCodexId = 2;
let illuminations;
let illumination;
let standardIllumination;

test.before(async t => {

    illuminations = await CodexIllumination.getByCodex(testCodexId);
    illumination = illuminations[0];
    standardIllumination =  illuminations[0];

    // Reset default values
    illumination.x = 28.8;
    illumination.y = 33.43;
    illumination.width = 27.4;
    illumination.height = 13.13;

    standardIllumination.x = 28.8;
    standardIllumination.y = 33.43;
    standardIllumination.width = 27.4;
    standardIllumination.height = 13.13;

});

test.beforeEach(async t => {

    illumination = standardIllumination;

    // Mount List view
    let Illuminations = Vue.extend(IlluminationList);
    vmList = new Illuminations({
        propsData : {
            codex : testCodexId
        }
    }).$mount();


    // Mount single view
    let IlluminationVue = Vue.extend(Illumination);
    vmSingle = new IlluminationVue({
        propsData : {
            original : illumination
        }
    }).$mount();

    // Mount modal view
    let Modal = Vue.extend(IlluminationModal);
    vmModal = new Modal({
        propsData: {
            codexId : testCodexId
        }
    }).$mount();

});

test.serial('it can fetch illuminations from the database using the class', async t => {

    let data = await CodexIllumination.getByCodex(testCodexId);
    t.true(data.length > 0);


});

test.serial('it can create a new codex illumination', t => {

    let illumination = new CodexIllumination();
    t.is(0, Object.keys(illumination.originalValues).length);
    t.is(null, illumination.manuscriptPage);

});

test.serial('it can create a codex illumination from existing data', async t => {

    t.true(illumination instanceof CodexIllumination);
    t.is(illumination.image, 21804);
    t.is(illumination.manuscriptPage, 37075);

});

test.serial('it detects if an illumination has been altered', t => {

    illumination.reset();
    t.false(illumination.hasBeenChanged());

    illumination.x = 2.3333;
    t.true(illumination.hasBeenChanged());

    illumination.reset();
    t.false(illumination.hasBeenChanged());

});

test.serial('the view receives a list of illuminations for the given codex', async t => {


    await vmList.getIlluminations().then(() => {
        t.true(vmList.illuminations.length > 0);
    });

});

test.serial('it renders a single illumination', async t => {

    t.is('nihil ut debitis', vmSingle.$el.querySelector('h4').textContent);

});

test.serial('it computes the live image link if nothing has changed', t => {

    let targetLink = "http://digilib.bbaw.de/digitallibrary/servlet/Scaler/IIIF/silo10!Koran!Gotha_Koranfragmente!Ms-orient-A-00427!Ms-orient-A-00427_002.tif/pct:28.8,33.43,27.4,13.13/full/0/default.jpg"

    vmSingle.illumination.reset();

    t.is(targetLink, vmSingle.liveImage);
    t.is(targetLink, vmSingle.$el.querySelector('img').getAttribute("src"));
    t.is(vmSingle.liveImage, vmSingle.$el.querySelector('img').getAttribute("src"));


});

test.serial('it alters the live image link when the image coordinates change', t => {

    let targetLink = "http://digilib.bbaw.de/digitallibrary/servlet/Scaler/IIIF/silo10!Koran!Gotha_Koranfragmente!Ms-orient-A-00427!Ms-orient-A-00427_002.tif/pct:25.5,30.43,23.4,11.13/full/0/default.jpg"

    // alter vm values
    vmSingle.illumination.x = 25.5;
    vmSingle.illumination.y = 30.43;
    vmSingle.illumination.width = 23.4;
    vmSingle.illumination.height = 11.13;

    t.is(targetLink, vmSingle.liveImage);

    // Make sure changed computed property is applied to the template DOM
    Vue.nextTick(() => {
        t.is(targetLink, vmSingle.$el.querySelector('img').getAttribute("src"));
        t.is(vmSingle.liveImage, vmSingle.$el.querySelector('img').getAttribute("src"));
    });

});

test.serial('the modal has the correct codex id', t => {

   t.is(testCodexId, vmModal.codexId);
   t.is(testCodexId, vmList.$refs.modal.codexId);

});

test.serial('it renders the modal with no specific illumination given', t => {

    // should both be null
    t.is(new CodexIllumination().title, vmModal.illumination.title);
    t.is('New Illumination', vmModal.title);
    t.is('New Illumination', vmModal.$el.querySelector('h4').textContent);

});


test.serial('an illumination list renders the single illumination components', async t => {

    await vmList.getIlluminations().then(() => {

        Vue.nextTick(() => {
            t.is(vmList.$el.querySelector(".illumination-title").textContent, 'nihil ut debitis');
        });

    })

});

test.serial('a click on the edit button updates the modal illumination data', async t => {

    // Modal should not be visible
    t.false(vmList.$el.querySelector("#illumination-modal").classList.contains("in"));

    await vmList.getIlluminations().then(() => {

        Vue.nextTick(() => {

            // Simulate button click
            vmList.$refs.illuminationItem[0].$refs.editButton.click();

            // Check whether illumination has changed
            t.is(vmList.$refs.illuminationItem[0].illumination, vmList.$refs.modal.illumination);

        });


    });

});

test.serial('a single illumination can get the data object', t => {

    t.true(illumination.data() instanceof Object);
    t.true(Object.keys(illumination.data()).length > 0);

});

test.serial('a single illumination can update the record in the database', async t => {

    let newX = illumination.x = faker.random.number(100);
    let newY = illumination.y = faker.random.number(100);
    let newWidth = illumination.width = faker.random.number(100);
    let newHeight = illumination.height = faker.random.number(100);

    await illumination.save().then(async data => {

        let updatedIlluminations = await CodexIllumination.getByCodex(testCodexId);
        let updatedIllumination = updatedIlluminations[0];

        t.is(newX, updatedIllumination.x);
        t.is(newY, updatedIllumination.y);
        t.is(newWidth, updatedIllumination.width);
        t.is(newHeight, updatedIllumination.height);

    });


});


test.serial('a new illumination can be saved', async t => {

    let startIlluminations = await CodexIllumination.getByCodex(testCodexId);

    // Set up new illumination
    let newIllumination = setupNewIllumination();

    await newIllumination.save(testCodexId);

    let savedIlluminations = await CodexIllumination.getByCodex(testCodexId);

    t.true(savedIlluminations.length > startIlluminations.length);

});

test.serial('an illumination can be deleted', async t => {

    let currentIlluminations = await CodexIllumination.getByCodex(testCodexId);

    let n = setupNewIllumination();
    await n.save(testCodexId);

    let updatedCounter = await CodexIllumination.getByCodex(testCodexId);
    t.true(updatedCounter.length > currentIlluminations.length);
    await n.remove();

    let removedCounter = await CodexIllumination.getByCodex(testCodexId);
    t.is(removedCounter.length, currentIlluminations.length);

});

test.serial('the modal can fetch a list of manuscripts and associated pages', async t => {

    await vmModal.getManuscriptPages().then(() => {
        t.is(vmModal.manuscripts.length, 2);
    });


});

test.serial('the modal has a select box with the fetched manuscripts as its options', async t => {

    await vmModal.getManuscriptPages().then(() => {

        Vue.nextTick(() => {

            let options = vmModal.$el.querySelectorAll("#manuscript-select option");
            t.is(options.length, 2);

            t.is(vmModal.manuscripts[0].manuscript, options[0].getAttribute("value"));
            t.is(vmModal.manuscripts[1].manuscript, options[1].getAttribute("value"));

            t.is(vmModal.manuscripts[0].manuscript, options[0].textContent.trim());
            t.is(vmModal.manuscripts[1].manuscript, options[1].textContent.trim());

        });

    });

});

test.serial('a selection of manuscript changes the page select box', async t => {

    await vmModal.getManuscriptPages().then(() => {

        vmModal.selectedManuscript = vmModal.manuscripts[0].manuscript;

        t.true(vmModal.pagesInManuscript.length > 0);

        Vue.nextTick(() => {

            let options = vmModal.$el.querySelectorAll("#page-select option");
            t.true(options.length > 0);
            t.true(options[0].textContent.trim().length > 0);

        });

    });

});

test.serial('it filters available pages when a manuscript is selected', async t => {

    // Before: pagesInManuscript should be empty
    t.true(vmModal.imagesForPage.length === 0);


    await vmModal.getManuscriptPages().then(() => {

        vmModal.selectedManuscript = vmModal.manuscripts[0].manuscript;
        vmModal.selectedPage = vmModal.manuscripts[0].pages[0].manuscriptPage;
        t.true(vmModal.imagesForPage.length > 0);

        Vue.nextTick(() => {
            let options = vmModal.$el.querySelectorAll("#image-select option");
            t.true(options.length > 0);
            t.true(options[0].textContent.trim().length > 0);
            t.true(options[0].textContent.includes("Version 1"));
        });

    });

});

test.serial('it shows the image for the selected manuscript page', async t => {

    // Before selection: image src should be empty
    t.is("", vmModal.selectedImageSrc);

    await vmModal.getManuscriptPages().then(() => {

        vmModal.selectedManuscript = vmModal.manuscripts[0].manuscript;
        vmModal.selectedPage = vmModal.manuscripts[0].pages[0].manuscriptPage;

        vmModal.selectedImage = vmModal.manuscripts[0].pages[0].images[0];
        t.true(vmModal.selectedImageSrc.length > 0);

    });

});

test.serial('an image region is selectable', async t => {


    await vmModal.getManuscriptPages().then(() => {

        vmModal.selectedManuscript = vmModal.manuscripts[0].manuscript;
        vmModal.selectedPage = vmModal.manuscripts[0].pages[0].manuscriptPage;
        vmModal.selectedImage = vmModal.manuscripts[0].pages[0].images[0];

        Vue.nextTick(() => {
            t.true(vmModal.cropper.getImageData() !== null);
        });

    });

});

test('it lists the presence of ornaments in the list view', t => {

    let newIllumination1 = setupNewIllumination();
    let newIllumination2 = setupNewIllumination();
    let newIllumination3 = setupNewIllumination();
    newIllumination3.illuminationType = "vignette";

    vmList.illuminations.push(newIllumination1);
    vmList.illuminations.push(newIllumination2);
    vmList.illuminations.push(newIllumination3);

    t.deepEqual(vmList.ornamentTypes, ["framing", "vignette"]);

});


/** Helper methods **/
function setupNewIllumination() {

    let newIllumination = new CodexIllumination();
    newIllumination.illuminationType = "framing";
    newIllumination.manuscriptPage = 37074;
    newIllumination.image = 21803;
    newIllumination.title = faker.lorem.words(3);
    newIllumination.description = faker.lorem.words(100);
    newIllumination.x = faker.random.number(100);
    newIllumination.y = faker.random.number(100);
    newIllumination.width = faker.random.number(100);
    newIllumination.height = faker.random.number(100);

    return newIllumination;

}


