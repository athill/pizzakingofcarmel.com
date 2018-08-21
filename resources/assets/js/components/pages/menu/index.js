import React, { Fragment } from 'react';
import axios from 'axios';

export const Links = ({ sections }) => (
	<ul>
		{
			sections.map(({id, title}) => (<li key={id}><a href={`#${id}`}>{title}</a></li>))
		}
	</ul>
);

const DownloadLink = () => (
	<div id="menu-download"><a href="down"><i className="fa-download"></i></a></div>
);

const Dict = ({ items }) => (
	<p>Dict</p>
);

const Feast = ({ items }) => (
	<p>Feast</p>
);

const Grid = ({ items }) => (
	<p>Grid</p>
);

const MenuType = ({ items }) => (
	<p>MenuType</p>
);

const createMarkup = html => ({ __html: html });

const Text = ({ content }) => (
	<div dangerouslySetInnerHTML={createMarkup(content)} />
);

const section = ({ content, items, type }, i) => {
	switch (type) {
		case 'dict':
			return <Dict items={items} key={i} />;
		case 'feast':
			return <Feast items={items} key={i} />;
		case 'grid':
			return <Grid items={items} key={i} />;
		case 'menu':
			return <MenuType items={items} key={i} />;
		case 'text':
			return <Text content={content} key={i} />;
	}
}

const MenuSection = ({ id, sections, title}) => (
	<div className="menu-section" id={id}>
		<div className="menu-section-title">{ title }</div>
		{
			sections.map((s, i) => section(s, i))
		}
	</div>
);


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
			console.log(data);
			return (
				<div id="menu-container">
					<Links sections={data} />
					<DownloadLink />
					{
						data.map(props => <MenuSection {...props} key={props.id} />)
					}
				</div>
			);			
		}
	}
}

export default Menu;
