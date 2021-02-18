import React from 'react';
import SectionList from './components/SectionList';
import Button from './elements/Button';
import WarningBar from "./elements/WarningBar";
import {upgrade} from './services/database';
import {fetchData} from "./services/api";

export default class CustomizerUI extends React.Component {

    state = {
        data: {}
    }

    constructor(props) {
        super(props);
        this.upgradeDatabase = this.upgradeDatabase.bind(this);
    }

    componentDidMount() {
        fetchData().then(data => this.setState({data}));
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