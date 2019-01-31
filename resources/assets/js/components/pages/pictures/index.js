import React from 'react';
import axios from 'axios';
import Lightbox from 'react-image-lightbox';

import 'react-image-lightbox/style.css';

const picPath = '/images/pictures';
const thumbPath = picPath + '/thumb';

class Pictures extends React.Component {
	constructor(props) {
		super(props);
		this.images = [];
		this.data = null;
		this.state = {

			loaded: false,
			isOpen: false,
			photoIndex: 0,


		}
	}

	componentDidMount() {
		axios.get('/api/pictures')
			.then(response => {
				this.data = response.data;
				response.data.sequence.forEach(key => {
					const filename = `${key}.${response.data.items[key].extension}`; // [key].extension ${response.data.items[key]}
					this.images.push(`${picPath}/${filename}`);
				});
				this.setState({
					loaded: true
				});
			});
	}

	open(index) {
		this.setState({
			isOpen: true,
			photoIndex: index
		});
	}

	render() {
		if (!this.state.loaded) {
			return <p>loading</p>
		} else {
			const { images, data } = this;
			const { isOpen, photoIndex } = this.state;
			return (
				<div id="pics">
					{
						data.sequence.map((key, index) => {
							const { extension, title} = data.items[key];
							const filename = `${key}.${extension}`;
							return (
								<div className="pics-thumbs" key={key} onClick={() => this.open(index)}>
									<img src={`/images/pictures/thumb/${filename}`} alt={title} />
									<div className="pics-title">{title}</div>
								</div>
							);
						})
					}
			        { isOpen && (
			          <Lightbox
			            mainSrc={images[photoIndex]}
			            nextSrc={images[(photoIndex + 1) % images.length]}
			            prevSrc={images[(photoIndex + images.length - 1) % images.length]}
			            onCloseRequest={() => this.setState({ isOpen: false })}
			            onMovePrevRequest={() =>
			              this.setState({
			                photoIndex: (photoIndex + images.length - 1) % images.length,
			              })
			            }
			            onMoveNextRequest={() =>
			              this.setState({
			                photoIndex: (photoIndex + 1) % images.length,
			              })
			            }
			          />
			        )}					
				</div>
			);			
		}

	}

}

export default Pictures;
