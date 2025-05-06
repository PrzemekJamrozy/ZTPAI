function useImageEncoder() {

    const encodeImage = async (image: File): Promise<string> => {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();

            reader.onload = () => {
                const result = reader.result as string;
                resolve(result);
            };

            reader.onerror = (error) => reject(error);

            reader.readAsDataURL(image);
        });
    }

    return encodeImage;
}

export { useImageEncoder };