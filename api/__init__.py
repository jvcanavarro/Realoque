"""
Base da API
"""

from flask import Flask, jsonify
import pandas as pd

app = Flask(__name__)
data = pd.read_csv('/home/tubs/HackSerpro/datasets/imoveis/imoveis_final.csv',sep=";", encoding="unicode_escape")


@app.route("/bairros")
def get_bairros():

    """
    Retorna os bairros com valores disponíveis
    :return:
    """

    l = list(data['Bairro'].values)
    l = list(dict.fromkeys(sorted(l)))

    return jsonify(l)

@app.route("/bairro/<string:bairro>")
def getBy_bairro(bairro):

    """
    Retorna os imóveis disponíveis em determinado municipio
    :param str bairro:
    :return:
    """

    print(bairro)

    response = []

    for i in data[data["Bairro"] == bairro].iterrows():

        response.append(i[1].to_json())

    print(response)

    return jsonify(response)

@app.route("/valor/<float:valor>")
def getBy_valor(valor):

    """
    Retorna os imóveis disponíveis de acordo com o valor
    :param valor:
    :return:
    """


if __name__ == "__main__":
    app.run(host = 'localhost', port = 7000, debug = False)
