import React from 'react';
import axios from 'axios';

class Pictures extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			data: null,
			images: {}
		}
	}

	componentDidMount() {
		axios.get('/api/pictures')
			.then(response => {
				this.setState({
					data: response.data
				});
				response.data.sequence.forEach(key => {
					const filename = `${key}.${response.data.items[key].extension}`; // [key].extension ${response.data.items[key]}
					console.log(filename);
					// axios.get(`/images/pictures/thumb/${filename}`)
					// 	.then(response => {

					// 	});
				});
			});
	}

	render() {
		const { data } = this.state;
		if (!data) {
			return <p>loading</p>
		} else {
			return (
				<div id="pictures">
					{
						data.sequence.map(key => {
							const { extension, title} = data.items[key];
							const filename = `${key}.${extension}`;
							return (
								<div key={key}>
									<img src={`/images/pictures/thumb/${filename}`} />
									<div>{title}</div>
								</div>
							);
						})
					}
				</div>
			);			
		}

	}

}

export default Pictures;
