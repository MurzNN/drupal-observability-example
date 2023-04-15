import ReactDOM from 'react-dom/client';
import InfiniteScroll from './InfiniteScroll';
import TraceProvider from './tracing';
const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <TraceProvider>
    <div className='App'>
      <h1>List of articles from Drupal</h1>
      <InfiniteScroll />
    </div>
  </TraceProvider>
);
