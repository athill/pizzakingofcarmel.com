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

const Feast = ({ items }) => (
	<Fragment>
		{
			items.map((item, index) => (
				<div key={`${item.title}-${index}`} className="feast-item">
					<span className="feast-title">{ item.title }</span>
					<span className="feast-toppings">{ item.toppings }</span>
				</div>
			))
		}
	</Fragment>
);

const imageDir = '/images/pictures';
const thumbDir = imageDir + '/thumb';

class HoverImage extends React.Component {
  constructor(props) {
  	super(props);
  	this.state = {
  		showFull: false
  	};
  	this.handleEnter = this.handleEnter.bind(this);
  	this.handleExit = this.handleExit.bind(this);
  }

  handleEnter() {
  	this.setState({
  		showFull: true
  	});
  }

  handleExit() {
  	this.setState({
  		showFull: false
  	});
  }

  render() {
  	const { item: { img, name } } = this.props;
  	const { showFull } = this.state;
    return (
    	<Fragment>{
    		img && (
    			<span className="hover-image">
    				<img alt={name}
    					 className="hover-thumb" 
						 onMouseEnter={this.handleEnter}	 
    					 src={`${thumbDir}/${img}`}
    				/> 
    				{ showFull && (
    					<img 
	    					src={`${imageDir}/${img}`} 
	    					className="hover-full" 
	    					onMouseLeave={this.handleExit}
	    					alt={name} 
	    				/>)
	    			}
    				&nbsp;
    			</span>
    		)
    	}
    	</Fragment>
    );
  }
}

const Grid = ({ items }) => {
	console.log(items);
	return (
		<table className="menu-table">
			<thead>
				<tr>
					{
						['', '8"', '10"', '14"', '16"'].map(header => <th key={header}>{header}</th>)
					}
				</tr>
			</thead>
			<tbody>
				{
					items.map((item, index) => (
						<tr key={index}>
							<td className="menu-item-name"><HoverImage item={item} />&nbsp;{item.name}</td>
							{
								item.prices.map((price, j) => (
									<td key={`${index}-${j}`}>{ price }</td>
								))
							}
						</tr>
					))
				}
			</tbody>
		</table>
	);
};

/*
	function displayGridMenu($items) {
		global $h;
		global $webroot;
		
		$headers = array('', '8"', '10"', '14"', '16"');
		$h->otable('class="menu-table"');
		foreach ($headers as $header) {
			$h->th($header);
		}
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			$h->cotr();
			$h->otd();
			$name = $this->image($item);

			

			$atts = 'class="menu-item-name"';
			$h->div($name, $atts);						
			$h->ctd();
			foreach ($item['prices'] as $l => $price) {
				$h->td(number_format($price, 2));
			}
		}
		$h->ctable();
	}
*/



const Price = ({ price }) => (
	<div>
	{ 
		price.split(';').map((p, i) => <div key={i}>{ p }</div>)
	}
	</div>
);


const MenuType = ({ items }) => (
	<div>
		{
			items.map((item, index) => {
				return (
					<div key={`${item.name}-${index}`} className="menu-item">
						<div className="menu-item-name-price-row">
							<div>
								<HoverImage item={item} />
								<strong>{ item.name }</strong>
							</div>
							
							<Price price={item.price} />
						</div>
						<div className="menu-item-price-descr" dangerouslySetInnerHTML={createMarkup(item.descr)} />
					</div>
				);
			})
		}
	</div>
);


const Text = ({ content }) => (
	<div dangerouslySetInnerHTML={createMarkup(content)} />
);

const Section = (props) => {
	const typeMap = {
		dict: Dict,
		feast: Feast,
		grid: Grid,
		menu: MenuType,
		text: Text
	};
	const TempComponent = typeMap[props.type] || Text;
	return (
		<div className="menu-subsection">
			<TempComponent {...props} />
		</div>
	);
}

const MenuSection = ({ id, sections, title}) => (
	<div className="menu-section" id={id}>
		<div className="menu-section-title">{ title }</div>
		{
			sections.map((s, i) => <Section key={i} {...s} /> )
		}
		<br /><br />
		<a href="#top" className="backtotop">Return to Top</a>		
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
