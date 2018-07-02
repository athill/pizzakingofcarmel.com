import React, { Fragment } from 'react';
import axios from 'axios';

class Menu extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			data: null
		}
	}

	componentDidMount() {
		axios.get('/api/menu')
			.then(response => {
				this.setState({
					data: response.data
				});
			});
	}

	render() {
		const { data } = this.state;
		if (!data) {
			return <p>loading</p>
		} else {
			return (
				<div id="menu">
					{
						data.map(({ id, title, sections }) => {
							return (
								<Fragment key={id}>
									<p key={id}>{ id }</p>
									<ul>
										{
											sections.map(({ type, items }, i) => (
												<li key={i}>{type}</li>
											))
										}
									</ul>
								</Fragment>
							);
						})
					}
				</div>
			);			
		}

	}

}

export default Menu;
