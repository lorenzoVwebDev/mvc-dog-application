export async function get_dogtable(formData) {
  const response = await fetch('https://apachebackend.lorenzo-viganego.com/mvc-dog-application/public/dog/insertdog', {
    method: "POST",
    body: formData
  });

  return response;
}