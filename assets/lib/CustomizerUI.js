import React from 'react';
import axios from 'axios';

export default class CustomizerUI extends React.Component {

    state = {
        data: []
    }

    componentDidMount() {
        axios.get('/wp-json/wpcui/v2/test')
            .then(res => {
                this.setState({data: res.data});
            });
    }

    render() {
        return (
            <ul>
                { this.state.data.map(item => <li>{item}</li>)}
            </ul>
        )
    }
}