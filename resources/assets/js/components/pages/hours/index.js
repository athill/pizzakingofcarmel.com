import React from 'react';

const hours = [
	{ label: 'Monday-Thursday', times: <span>11:00am&nbsp;to&nbsp;10:00pm</span> },
	{ label: 'Friday', times: <span>11:00am&nbsp;to&nbsp;11:00pm</span> },
	{ label: 'Saturday', times: <span>4:00pm&nbsp;to&nbsp;11:00pm</span> },
	{ label: 'Sunday', times: <span>4:00pm&nbsp;to&nbsp;10:00pm</span> }
];

const Hours = () => (
	<div id="hours" className="container">
	{
		hours.map(hour => (
			<div className="row">
				<div className="col-12 col-md-6 label">{ hour.label }:</div>
				<div className="col-12 col-md-6">{ hour.times }</div>
			</div>
		))
	}
	</div>
);
export default Hours;
