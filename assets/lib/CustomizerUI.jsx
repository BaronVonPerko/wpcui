import React from 'react';
import axios from 'axios';
import SectionList from './components/SectionList';
import Button from './elements/Button';
import WarningBar from "./elements/WarningBar";
import {upgrade} from './services/database';

export default class CustomizerUI extends React.Component {

    state = {
        data: {}
    }

    constructor(props) {
        super(props);
        this.upgradeDatabase = this.upgradeDatabase.bind(this);
    }


    componentDidMount() {
        axios.get('/wp-json/wpcui/v2/getOptions')
            .then(res => {
                this.setState({data: res.data});
            });
    }

    upgradeDatabase() {
        upgrade(this.state.data)
    }

    databaseUpgradeWarning() {
        return (
            <WarningBar
                title="Database Upgrade Required"
                buttonText="Upgrade Now"
                buttonClick={this.upgradeDatabase}
                innerText="Your database needs to be updated in order to use this version of the Customizer UI plugin.  It is recommended that you create a backup of your database before continuing."/>
        )
    }

    render() {
        if (this.state.data.db_version < 2) {
            return this.databaseUpgradeWarning();
        } else if (this.state.data.sections) {
            return (
                <div>
                    <Button buttonType="primary" innerText="Create New Section"/>
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