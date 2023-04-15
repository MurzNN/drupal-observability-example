import { useEffect, useState } from 'react';
import ContentComponent from './ContentComponent';
function InfiniteScroll () {
	const [dataSource, setdataSource] = useState([]);
	const [page, setPage] = useState(1);
	const getData = async () => {
		let DataResponse = await fetch(`https://drupal-opentelemetry-example.ddev.site/api/nodes?_format=json&page=${page}`);
		let DataParsed = await DataResponse.json();
		const Data = DataParsed;
		setdataSource((prev) => [...prev, Data]);
	};
	useEffect(() => {
		getData();
	}, [page]);
	const handelInfiniteScroll = async () => {
		try {
			if (
				window.innerHeight + document.documentElement.scrollTop + 1 >=
				document.documentElement.scrollHeight
			) {
				setPage((prev) => prev + 1);
			}
		} catch (error) {
			console.log(error);
		}

	};
	useEffect(() => {
		window.addEventListener('scroll', handelInfiniteScroll);
		return () => window.removeEventListener('scroll', handelInfiniteScroll);
	}, []);
	return (
		<>
			<ContentComponent content={dataSource} />

		</>
	);
}
export default InfiniteScroll;
