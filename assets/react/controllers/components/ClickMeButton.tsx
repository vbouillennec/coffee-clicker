const ClickMeButton = (props: { handleClick: () => void }) => {
    return (
        <button
            id="click-me-button"
            style={{ transform: "scale(1)" }}
            className="bg-purple-700 hover:bg-purple-500 text-white font-bold py-2 px-4 border-b-4 border-purple-900 hover:border-purple-700 rounded"
            onClick={props.handleClick}
        >
            Click me !
        </button>
    );
};

export default ClickMeButton;
