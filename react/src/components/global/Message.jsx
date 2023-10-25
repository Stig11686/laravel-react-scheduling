function Message({ message }) {
    {
        if (!message) return;

        const { type, ...messages } = message;

        return (
            <div
                className={`${
                    type === "error" ? "bg-red-500" : "bg-green-500"
                } text-white rounded p-4`}
            >
                {Object.keys(messages).map((key) => (
                    <p key={key}>{message[key]}</p>
                ))}
            </div>
        );
    }
}

export default Message;
