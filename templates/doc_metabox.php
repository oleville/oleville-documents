<div id="datetime">
<label for="date">Date</label>
<br />
<input type="text" class="date" id="date" name="date" value="<?php echo get_post_meta($post->ID, 'date', TRUE) ?>"/>
<br />
</div>
<label for="pri_author">Authors</label>
<br />
<input type="text" id="pri_author" name="pri_author" placeholder="primary author" value="<?php echo get_post_meta($post->ID, 'pri_author', TRUE) ?>"/>
<input type="text" id="pri_title" name="pri_title" placeholder="author's title" value="<?php echo get_post_meta($post->ID, 'pri_title', TRUE) ?>"/>
<br />
<input type="text" id="sec_author" name="sec_author" placeholder="secondary author" value="<?php echo get_post_meta($post->ID, 'sec_author', TRUE) ?>"/>
<input type="text" id="sec_title" name="sec_title" placeholder="author's title" value="<?php echo get_post_meta($post->ID, 'sec_title', TRUE) ?>"/>
<br />
<input type="text" id="tri_author" name="tri_author" placeholder="tertiay author" value="<?php echo get_post_meta($post->ID, 'tri_author', TRUE) ?>"/>
<input type="text" id="tri_title" name="tri_title" placeholder="author's title" value="<?php echo get_post_meta($post->ID, 'tri_title', TRUE) ?>"/>
<br />
<label for="purpose">Purpose</label>
<br />
<textarea id="purpose" name="purpose" style = "width:400px; height:100px;"/><?php echo get_post_meta($post->ID, 'purpose', TRUE) ?></textarea>
<br />
<label for="explanation">Explanation</label>
<br />
<textarea id="explanation" name="explanation" style= "width:400px; height:100px;"/><?php echo get_post_meta($post->ID, 'explanation', TRUE) ?></textarea>
<br />
<label for="signature1">Signatures</label>
<br />
<input type="text" id="signature1" name="signature1" value="<?php echo get_post_meta($post->ID, 'signature1', TRUE) ?>"/>
<input type="text" class="date" id="dateSigned1" name="dateSigned1" value="<?php echo get_post_meta($post->ID, 'dateSigned1', TRUE) ?>"/>
<br />

<input type="text" id="signature2" name="signature2" value="<?php echo get_post_meta($post->ID, 'signature2', TRUE) ?>"/>
<input type="text" class="date" id="dateSigned2" name="dateSigned2" value="<?php echo get_post_meta($post->ID, 'dateSigned2', TRUE) ?>"/>
<br />
