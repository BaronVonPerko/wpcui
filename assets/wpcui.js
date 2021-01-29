import React from 'react';
import ReactDOM from 'react-dom';
import CustomizerUI from "./lib/CustomizerUI";

document.addEventListener('DOMContentLoaded', () => {
   ReactDOM.render(<CustomizerUI />, document.getElementById('wpcui-app'));
});