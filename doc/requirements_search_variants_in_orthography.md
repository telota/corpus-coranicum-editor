# Requirements: Search for Variants in Orthography

## Search Options

1. Search **from** a given word coordinate to the last Qur'an coordinate. 
Different levels of coordinate precision are allowed:
  * from a given sura; e.g. from sura 15 (up to the end of the Qur'an)
  * from a given verse; e.g. from sura 15, verse 3 (up to the end of the Qur'an)
  * from a given word; e.g. from sura 15, verse 3, word 4 (up to the end of the Qur'an)
  
*Use the fields `sure`, `vers` and `word`in the `manuskriptseiten_variant_orthography` for checking the coordinates.*
  
2. Search from first word **up to** a given word coordinate. 
Different levels of coordinate precision are allowed:
  * up to a given sura; e.g. from the first word of the Qur'an up to (including) sura 15
  * up to a given sura; e.g. from the first word of the Qur'an up to (including) sura 15, verse 3
  * up to a given sura; e.g. from the first word of the Qur'an up to (including) sura 15, verse 3, word 4
  
*Use the fields `sure`, `vers` and `word`in the `manuskriptseiten_variant_orthography` for checking the coordinates.*
  
3. Search **between** a given range of word coordinates.
Different levels of coordinate precision are allowed:
  * from a given sura, up to another given sura; e.g. from sura 2, up to (including) sura 15
  * from a given sura, up to given verse; e.g. from sura 2, up to (including) sura 15, verse 3
  * from a given sura, up to given word; e.g. from sura 2, up to (including) sura 15, verse 3, word 4
  * from a given verse, up to a given sura; e.g. from sura 2, verse 100, up to (including) sura 15
  * from a given verse, up to another given verse; e.g. from sura 2, verse 100, up to (including) sura 15, verse 3
  * from a given verse, up to a given word; e.g. from sura 2, verse 100, up to (including) sura 15, verse 3, word 4
  * from a given word, up to a given sura; e.g. from sura 2, verse 100, word 2, up to (including) sura 15
  * from a given word, up to a given verse; e.g. from sura 2, verse 100, word 2, up to (including) sura 15, verse 3
  * from a given word, up to a given word; e.g. from sura 2, verse 100, word 2, up to (including) sura 15, verse 3, word 4
    
*Use the fields `sure`, `vers` and `word`in the `manuskriptseiten_variant_orthography` for checking the coordinates.*

4. Search in **textual** information that are not the variants themselves:
Search in the following fields and conditions:
  * `comment` in `manuskriptseiten_variant_orthography`
  * in table `image_details`, when `relation` equals `manuskriptseiten_variant_orthography`
    * `title`
    * `description`
    
5. Search in the **variants**
  * exact matches for `variant` in `manuskriptseiten_variant_orthography`
  * matches with wildcards for `variant` in `manuskriptseiten_variant_orthography`
  * rasm search (use [rasmify](https://github.com/telota/rasmify) for normalization of query and database entries) for
  `variant` in `manuskriptseiten_variant_orthography`
  
6. Filter data using `feature` checkboxes. Following values:
  * `strange_character` - Strange Character
  * `orthographic_difference` - Orthographic Difference
  * `illegible` - Illegible
  * `uncertain` - Uncertain
  
7. Any combination of 1-6.

## Further Requirements and Requests

* When possible, please use query scopes
* Please add unit tests for the searches 1-6 and a few for mixed scenarios in 7