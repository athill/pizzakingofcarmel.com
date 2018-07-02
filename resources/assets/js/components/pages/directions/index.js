import React from 'react';

const Home = () => (
	<div id="directions">
		<img src="/images/directions.png" alt="Map of store area" id="directions-map"/>
		<br />
		<p>Pizza King of Carmel is located in the Carmel Court Office Plaza:</p>
		<p className="indent">301 E. Carmel Dr., Suite A-800</p>
		<p>
		On the south side of Carmel Drive in between Keystone Parkway and Rangeline Road. We are in the same building as MacNamara Florist.
		</p>
		{/* // TODO: get api key, etc. https://cloud.google.com/maps-platform/user-guide/account-changes/?utm_source=maps_js&utm_medium=degraded&utm_campaign=keyless#no-plan
		<form action="index.php#directions" method="get">
		<strong>Where are you?</strong>
		<input id="start" type="text" name="start"/>
		<input id="btn" type="submit" name="btn" value="Get Directions"/>
		</form>
		*/}
	</div>
);

export default Home;
