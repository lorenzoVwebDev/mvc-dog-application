
export async function downloadTable(type, url){
    const response = await fetch(`${url}logs/table?type=${type}`)

    if (response.status >= 200 && response.status < 400) {
      const result = await response.text();
      return result;
    } else if (response.status >= 400 && response.status < 500 ){
      const error = response;
      throw new Error(error)
    } else {
      const error = response;
      throw new Error(error)
    }
}