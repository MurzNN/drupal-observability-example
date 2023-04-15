import React from 'react';
const ContentComponent = ({ content }) => {
	return (
			<div className="wrapper">
				<div className="container">

					{

						content.map((item, index) => {
							return (
								<div key={index}>
									<h2 >Title: {item[0].title[0].value}</h2>
									<div>{item[0].body[0].summary.substring(0, 600)}</div>
									<hr/>
									<h2 >Title: {item[1].title[0].value}</h2>
									<div>{item[1].body[0].summary.substring(0, 600)}</div>
									<hr/>
									<h2 >Title: {item[2].title[0].value}</h2>
									<div>{item[2].body[0].summary.substring(0, 600)}</div>
									<hr/>
								</div>

							);
						})
					}

				</div>
			</div>

	);
};
export default ContentComponent;
