@extends("layouts.master")

@section("title")
    <div id="transliteration-help">
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#helpCollapse" aria-expanded="true" aria-controls="helpCollapse">
            Help / Guidelines
        </button>
        <div class="collapse" id="helpCollapse">
            <div class="card card-block">
                <ul>
                    <li>
                        To maintain a functioning wordcount refrain from writing additional words in the editor.
                        Please only use the functionality of adding words to the lines from the generated wordlist.
                    </li>
                    <li>
                        Once added to a line, words can be marked. You may change the characters of the word,
                        however please refrain from deleting whole words from the editor (and rewriting them).
                    </li>
                    <li>
                        If you want to delete a word from a line please press the buttons, representing the words
                        you want to drop, in the currently active line.
                    </li>
                    <li>
                        The wordlist is generated according to the input (wordrange) on the manuscriptpage. If you notice
                        you need more words at the beginning or the end of the page please save the transliteration and
                        edit the textrange on the manuscriptpage.
                    </li>
                    <li>
                        In the active line you can see the words with their corresponding word-identifiers.
                        Please check their consistency (successive word-identifiers etc.) <b>before</b> saving the line.
                        For the unlikely event that a word gets a word-identifier as "undefined" please redo the corresponding
                        line.
                    </li>
                </ul>
                <hr>
                <ul>
                    <li>
                        For adding verse-separators there are two options.
                        You can find regular (according to the kūfic system) verse-separators in the
                        generated wordlist and has the word-id "sura:verse:999".
                        If you are in need of non-kūfic seperators please use the button below the wordlist.
                        It gets a static word-id of "000:000:999".

                    </li>
                    <li>
                        Explicitly numbering the verse-seperators is no longer required -
                        only the differenciation found in the manuscript should be noted,
                        i.e. verse-seperators depicted as fifth or tenth should carry a "5" or "10",
                        if abjad-characters are used they should be typed as well.
                    </li>
                    <li>
                        If a word is written across two lines, just add the word to both lines and
                        crop it according to the manuscript.
                    </li>
                    <li>
                        In contrast to the previous way of transliterating and marking of omitted characters,
                        the Cairene version of characters is kept <b>and</b> marked with <span class="omitted">"Omitted"</span>.
                        It is no longer the preceeding character that gets marked!
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div id="transliterationEditor">
        <editor id="transliterationSummernote"></editor>
        <!-- Container containing all the words which are possibly on the page -->
        <div class="flex-container" >
            <div id="wordListContainer">
                <div class="panel panel-default panel-primary" >
                    <div class="panel-heading ">
                        <h3 class="panel-title">Wordlist</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($words as $word)
                            <li class="list-group-item wordListContent">
                                    <div id="wordProperties">
                                        <span class="wordnumber">
                                            {{$word->sure}}:{{$word->vers}}:{{$word->wort}}
                                        </span>
                                        <span class="arab">
                                            {{$word->arab}}
                                        </span>
                                    </div>
                                    <div class="wordListButton">
                                        <button class="btn btn-primary " v-on:click="addWordToLine({{$word}})" :disabled="!isActiveLine()">
                                            Add
                                        </button>
                                    </div>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <div class="panel-footer" id="specialVerseSeperator">
                        <ul class="list-group">
                            <li class="list-group-item wordListContent">
                                <div id="wordProperties">
                                    <span class="wordnumber">
                                        {{$verseSeperatorStandard->sure}}:{{$verseSeperatorStandard->vers}}:{{$verseSeperatorStandard->wort}}
                                    </span>
                                    <span class="arab">
                                        {{$verseSeperatorStandard->arab}}
                                    </span>
                                    <span>
                                        Non-kūfic Seperator
                                    </span>
                                </div>
                                <div class="wordListButton">
                                    <button class="btn btn-primary " v-on:click="addWordToLine({{$verseSeperatorStandard}})" :disabled="!isActiveLine()">
                                        Add
                                    </button>
                                 </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Container for all the Lines on a Page -->
            <div id="lineListContainer" >
                <div>
                <div class="panel panel-default panel-primary" v-bind:current-line-list="{{$transliterationLines}}">
                    <div class="panel-heading ">
                        <h3 class="panel-title">Linelist</h3>
                    </div>
                    <line-list ref="lines" :current-line-list="{{json_encode($transliterationLines)}}"></line-list>
                    <div class="panel-body">
                        <div class="lines well"  v-for="line in lineList" v-bind:class="{activeLine: line.isActive}">
                            <div class="lineNumber">
                                @{{line.number}}
                            </div>
                            <!-- Words in line, Buttons if activeLine, and Text if line is deactivated -->
                            <div class="lineContent">
                            <span  v-for="word in line.getWords()">
                                <button v-if="line.isActive" v-on:click="deleteWordFromLine(word)" >
                                   <span class="arab">@{{word.text}}</span>
                                    <span class="wordnumber">@{{word.number}}</span>
                                </button>
                            </span>
                                <p class="arab" v-html="line.getWordString()" class="lineText" v-if="!line.isActive"></p>
                            </div>

                            <!-- Buttons for managing single lines (delete, save & edit)-->
                            <div class="lineButtons">
                                <button class="btn btn-primary" v-on:click="setLineActive(line)" :disabled="line.isActive">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
                                </button>
                                <button class="btn btn-default" v-on:click="setLineInactivate(line)" :disabled="!line.isActive">
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Save
                                </button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteLineModal"v-on:click="setDeletionData(line)">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div id="addLineContainer">
                            <div>
                                <input id="lineNumber" type="number" v-bind:value="lineList.length+1" v-model="selectedOption" v-bind:max="lineList.length+1" v-bind:min="1">
                                <button class="btn btn-primary" data-toggle="tooltip"
                                        title="Add new line at selected position. Enter desired line-number in the input-field. The input must be a number, not smaller than one and not greater than the current length of the list plus one."
                                        v-model="selectedOption" v-on:click="addLine(selectedOption)"
                                        :disabled="selectedOption > lineList.length+1 || selectedOption <= 0 || isNaN(selectedOption)">
                                    Add Line
                                </button>
                            </div>
                            <div>
                                <button id="saveTransliterationButton"class="btn btn-primary" v-on:click="saveAllLines({{$id}})">Save Transliteration</button>
                            </div>
                        </div>
                    </div>
                    <!-- PopUp window for asking, if User is sure to delete selected line -->
                </div>
                </div>

                <div class="modal fade" id="deleteLineModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Are you sure you want to delete line: "@{{deletedLine.number}}" ?</h4>
                            </div>
                            <div class="modal-body arab">
                                <p v-html="deletedLine.getWordString()"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-danger deleteButton"  data-dismiss="modal" v-on:click="deleteLine(deletedLine)">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selection for place to insert Line + insert Line-->


                <div class="modal fade" id="errorInLineModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="undefinedWordError"></h4>
                            </div>
                            <div class="modal-body arab">
                                <p id="errorLine"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection



