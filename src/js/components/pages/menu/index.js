import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faPrint } from '@fortawesome/free-solid-svg-icons';
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

const PrintLink = () => (
	<div id="menu-download"><a href="/print" title="print"><FontAwesomeIcon icon={faPrint} /></a></div>
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
	return (
		<div className="menu-table-wrapper">
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
		</div>
	);
};

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

const TwoColCenter = ({ items }) => (
	<div className="pk-menu-2-col-center">
	{
		items.map((item, i) => (
			<div className="pk-menu-row" key={i}>
				<div>{ item.left }</div>
				<div>{ item.right }</div>
			</div>
		))
	}
	</div>
);

const ThreeCol = ({ items }) => (
	<div className="pk-menu-3-col">
	{
		items.map((item, i) => (
			<div className="column" key={i}>
				<div className="title">{ item.title }</div>
				<Text content={ item.descr } />
			</div>
		))
	}
	</div>
);

/*
		          
	function display3Col($items) {
		global $h;
		$h->odiv('class="pk-menu-3-col"');
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			if (!$this->form) $h->odiv('class="column"');
			if ($this->form) {
				$h->odiv('class="title"');
				$h->intext($basename.'_title', $item['title']);
				$h->cdiv('.title');
				$h->odiv('class="descr"');
				$h->editor($basename.'_descr', $item['descr'], 'style="width: 99%;"');
				$h->cdiv('.descr');
			} else {
				$h->div($item['title'], 'class="title"');
				$h->div($item['descr'], 'class="descr"');
			}
			if (!$this->form) $h->cdiv('.column');			
		}
		$h->cdiv();                          
	} 
*/

const Section = (props) => {
	const typeMap = {
		'2-col-center': TwoColCenter,
		'3-col': ThreeCol,
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

const MenuSection = ({ id, print, sections, title}) => (
	<div className="menu-section" id={id}>
		<div className="menu-section-title">{ title }</div>
		{
			sections.map((s, i) => <Section key={i} {...s} /> )
		}
		{ !print && 
			<Fragment>
				<br /><br />
				<a href="#top" className="backtotop">Return to Top</a>
			</Fragment>
		}

	</div>
);


const ScreenMenu = ({ data }) => (
	<div className="menu-container menu-screen">
		<PrintLink />
		<Links sections={data} />
		{
			data.map(props => <MenuSection {...props} key={props.id} />)
		}
	</div>
);



const PrintMenu = ({ data }) => {
	const pivot = 3;
	const columns = [data.slice(0, pivot), data.slice(pivot)];
	return (
		<div className="menu-print">

			{
				columns.map(column => (
					<div className="menu-container" key={column[0].id}>
						{
							column.map(props => <MenuSection key={props.id} print={true} {...props} />)
						}
					</div>
				))

			}
		</div>
	);
}

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
		const { print } = this.props;
		const { data } = this.state;
		if (!data) {
			return <p>loading</p>
		} else {
			return print && <PrintMenu data={data} /> || <ScreenMenu data={data} />;			
		}
	}
}

export default Menu;
