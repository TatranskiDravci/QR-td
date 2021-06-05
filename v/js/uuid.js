const uuid = () => {
    let id = String(Date.now());
    const idLen = 58 - id.length;
    for(let i = 0; i < idLen; i++) {
        id += String(Math.floor(Math.random() * 10));
    }
    return id;
};
