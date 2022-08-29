const fileSizeFilter = (fileSize = 0) => {
	let sizesPrefix = ["Bytes", "KB", "MB", "GB", "TB"]
	if (fileSize == 0) return "0 Byte"
	let i = parseInt(Math.floor(Math.log(fileSize) / Math.log(1024)))
	return Math.round(fileSize / Math.pow(1024, i), 2) + " " + sizesPrefix[i]
}

export default fileSizeFilter
