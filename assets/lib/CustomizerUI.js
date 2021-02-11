import React from 'react';
import axios from 'axios';
import SectionList from './components/SectionList';

export default class CustomizerUI extends React.Component {

    state = {
        data: {}
    }

    componentDidMount() {
        axios.get('/wp-json/wpcui/v2/getOptions')
            .then(res => {
                this.setState({data: res.data});
            });
    }

    render() {
        if(this.state.data.sections) {
            return (
                <SectionList sections={this.state.data.sections}/>
            )
        } else {
            return (
                <p>Loading ...</p>
            )
        }
    }
}