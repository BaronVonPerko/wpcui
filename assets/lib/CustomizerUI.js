import React from 'react';
import axios from 'axios';

export default class CustomizerUI extends React.Component {

    state = {
        data: []
    }

    componentDidMount() {
        axios.get('/wp-json/wpcui/v2/getCustomizerSections')
            .then(res => {
                this.setState({data: res.data});
            });
    }

    render() {
        return (
            <p>Loading...</p>
        )
    }
}