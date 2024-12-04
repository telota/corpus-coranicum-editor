import $, { data } from 'jquery';
const cachedRoutes: Record<string, any> = {};
const ajaxRoot = [process.env.MIX_APP_SUBPATH, '/ajax'].join('');
console.log('Here is the ajax root!', ajaxRoot);

function fetchJsonData<T>(url: string, callback: (data: T) => void):void {
  if (cachedRoutes[url]) {
    if(cachedRoutes[url] == 'fetching'){
     setTimeout(()=>fetchJsonData(url, callback), 200);
     return;
    }else {
      callback(cachedRoutes[url]);
      return;
    }
  }
  cachedRoutes[url] = 'fetching';
  $.getJSON(ajaxRoot + url, (data) => {
    cachedRoutes[url] = data;
    callback(data);
  });
}

function fetchMarkup<T>(url: string, callback: (data: T) => void) {
  if (cachedRoutes[url]) {
    callback(cachedRoutes[url]);
    return;
  }
  $.get(ajaxRoot + url, (data) => {
    cachedRoutes[url] = data;
    callback(data);
  });
}

export {fetchJsonData, fetchMarkup}
