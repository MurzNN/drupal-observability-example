import React from 'react';
const ContentComponent = ({ content }) => {
	return (
		<div className="wrapper">
			<div className="container">
				{
					content.map((item, index) => (
						<div key={index}>
							<h2>Bundle {index + 1}:</h2>
							{
								item.map((data, dataIndex) => {
									return (
										<div key={index + '_' + dataIndex}>
											<h3 >Node {data.nid[0]?.value}: {data.title[0]?.value}</h3>
											<div>{data.body[0]?.summary.substring(0, 600)}</div>
											<hr />
										</div>
									);
								})
							}
						</div>
					))
				}
			</div>
		</div>

	);
};
export default ContentComponent;
