import React, { Fragment } from 'react';
import axios from 'axios';

const createMarkup = html => ({ __html: html });

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
	<dl className="pk-menu-dict">
	{
		items.map(item => (
			<Fragment key={item.left}>
				<dt>{ item.left }</dt>
				<dd dangerouslySetInnerHTML={createMarkup(item.right)} />
			</Fragment>
		))
	}
	</dl>
);

/*
	function displayDictionary($items) {
		global $h;
		$h->otag('dl', 'class="pk-menu-dict"');
		foreach ($items as $k => $item) {
				$h->dt($item['left'].':');
				$h->dd($item['right']);
		}
		$h->ctag('dl');
	}
*/

const Feast = ({ items }) => (
	<Fragment>
		<h4>Feast Items</h4>
		{
			items.map((item, index) => (
				<div className="feast-item">
					<span className="feast-title">{ item.title }</span>
					<span className="feast-toppings">{ item.toppings }</span>
				</div>
			))
		}
	</Fragment>

				// 	$h->odiv('class="feast-item"');
				// $title = $this->image($item, 'title');
				// $h->span($title, 'class="feast-title"');
				// $h->span($item['toppings'], 'class="feast-toppings"');
				// $h->cdiv();
);

const Grid = ({ items }) => (
	<p>Grid</p>
);

const imageDir = '/images/pictures';
const thumbDir = imageDir + '/thumb';

// const Price = price => {
// 	price = price.replace('<br />', ';');
// 	price = price.explode(';').map(part => <div>{ part }</div>);

// 	return <span>price</span>;

// };

const MenuType = ({ items }) => (
	<div>
		<p>MenuType</p>
		{
			items.map((item, index) => {
				// const name = item.name;

				return (
					<div key={`${item.name}-${index}`} className="menu-item">
						<div className="menu-item-name-price-row">
							<strong>
								{
									item.img && <span><img src={`${thumbDir}/${item.img}`} rel={`${imageDir}/${item.img}`} width="50" alt={item.name} /> &nbsp;</span>
								}							
								{ item.name }
							</strong>
							<div>
								{item.price}
							</div>
						</div>
						<div className="menu-item-price-descr" dangerouslySetInnerHTML={createMarkup(item.descr)} />
					</div>
				);
			})
		}
	</div>
);

/*
	function displayMenu($items) {
		global $h;
		global $webroot;
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			$h->odiv('class="menu-item"');
			$h->odiv('class="menu-item-name-price-row"');
			$name = $item['name'];
			if (array_key_exists('img', $item) && !$this->form) {
				$src = $webroot.'/img/pictures/'.$item['img'];
				$thumb = $webroot.'/img/pictures/thumb/'.$item['img'];
				$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
					'width="50" alt="'.$item['name'].'" /> ' . $name;
			}
			$atts = 'class="menu-item-name left"';
			$h->div($name, $atts);	
			$atts = 'class="menu-item-price right"';
			$price = preg_replace("/;/", "<br />", $item['price']);
			$price = preg_replace("/:/", "&nbsp;", $price);
			$h->div($price, $atts);
			$h->cdiv('.menu-item-name-price-row');
			$atts = 'class="menu-item-descr"';
			$h->div($item['descr'], $atts);
			$h->cdiv('menu-item');
		}
	} 
*/


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
