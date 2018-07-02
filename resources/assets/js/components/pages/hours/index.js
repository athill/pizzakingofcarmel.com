import React from 'react';

const Hours = () => (
	<div id="hours" className="container">
		<div className="row">
			<div className="col-sm label">Monday-Thursday:</div>
			<div className="col-sm">11:00am to 10:00pm</div>
		</div>
		<div className="row">
			<div className="col-sm label">Friday:</div>
			<div className="col-sm">11:00am to 11:00pm</div>
		</div>
		<div className="row">
			<div className="col-sm label">Saturday:</div>
			<div className="col-sm">4:00pm to 11:00pm</div>
		</div>
		<div className="row">
			<div className="col-sm label">Sunday:</div>
			<div className="col-sm">4:00pm to 10:00pm</div>
		</div>		
	</div>
);

export default Hours;
