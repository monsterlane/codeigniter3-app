
<section>
	<header>
		<hgroup>
			<h1>AJAX conduit examples</h1>
		</hgroup>
	</header>

	<ul>
		<li><button id="appJsonButton" type="button" data-url="<?=base_url( 'example/data' )?>">JSON</button></li>
		<li><button id="appViewButton" type="button" data-url="<?=base_url( 'example/view' )?>">View</button></li>
		<li><button id="appFormAButton" type="button">Form method A</button></li>
		<li><button id="appFormBButton" type="button">Form method B</button></li>
	</ul>

	<div id="appViewArea"></div>

	<form id="appDemoForm" method="post" action="<?=base_url( 'example/form' )?>">
		<input type="hidden" name="test" value="1" />
	</form>
</section>
