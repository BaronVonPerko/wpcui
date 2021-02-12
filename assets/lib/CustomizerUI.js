import React from 'react';
import axios from 'axios';
import SectionList from './components/SectionList';
import Button from './components/Button';

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
                <div>
                    <Button buttonType="primary" innerText="Create New Section" />
                    <SectionList sections={this.state.data.sections}/>
                </div>
            )
        } else {
            return (
                <p>Loading ...</p>
            )
        }
    }
}