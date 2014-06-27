<?php
session_start();
require 'core/init.php';
include 'layout/head.php';
include 'layout/header.php';

?>



<div class='faqs'>
	<h1>Frequently asked questions</h1>
	
	<h2>What is a Stub?</h2>
	<p>A stub is a placeholder for you future work. Authors often want to cite work that has not been submitted or accecpted. In order that you don't miss out on potential citations you can cite your Stub. Simply add http://cite.pub/YourStubCode to your reference list. When your work is accepted or published log on to <a href='http://cite.pub' title="Cite.pub" alt="Cite.pub">http://Cite.pub</a> and add your DOI to the Stub. If anyone goes to your stub URL we will redirect them to your published article. Until then, it will take the reader to a placeholder page with a title and description of the work.</p>
	
	<h2>Is there a fee for adding a stub?</h2>
	<p>No. Cite.pub is free for authors to add as many stubs as they wish.</p>
	
	<h2>Do you offer any premium services?</h2>
	<p>Currently not. We will be adding features over time some of which may or may not be paid services. This will not affect the way authors submit Stubs.</p>
	
	<h2>Why do I need and ORCID?</h2>
	<p>Getting an ORCID is easy (get yours <a href="http://orcid.org/" title="ORCID">here</a>). ORCID provides a persistent digital identifier that distinguishes you from every other researcher. You can search for other users using their ORCID and see what work they have in the pipeline, if they have submitted a Stub.</p>
</div>

<?php
include 'layout/footer.php';
?>
