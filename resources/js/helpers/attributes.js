const getAttributes = image => {
    let attributes = [
        image.url ? `src="${image.url}"` : "",
        image.title ? `title="${image.title}"` : "",
        image.alt ? `alt="${image.alt}"` : ""
    ].filter(attr => attr !== "");
    return attributes.join(" ");
};

export default getAttributes;
